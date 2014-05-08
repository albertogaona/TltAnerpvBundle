<?php
namespace Tlt\AnerpvBundle\Services;

use Symfony\Component\DependencyInjection\Container;
/**
 * Comunica con el webservice de centinela provisto por webmaps para notificación
 * y seguimiento de emergencias a la autoridad federal.
 * @author Alberto Gaona
 *
 */
class CentinelaService
{
	private $container;
	private $key;
	private $baseUri;
	private $wsdlReportarEmergencia = '/reportarEmergencia.php?wsdl';
	private $wsdlConsultarStatus = '/consultarStatus.php?wsdl';
	
	
	/**
	 * Reportar emenrgencia. Los parámetros deben incluir:
	 * folio: 0 en caso de nueva emergencia, folio previamente asignado en caso de seguimiento
	 * longitud: lon de un LatLng
	 * latitud: lat de un LatLng
	 * fecha: en formato AAAA-MM-DD hh:mm:ss
	 * placa: de 6 a 20 caracteres
	 * modelo: de 4 a 50 caracteres
	 * color: de 2 a 20 caracteres
	 * @param array $params Arreglo de parámetros
	 * @return status
	 */
	public function reportarEmergencia($params)
	{
		$soapClient = new \SoapClient($this->baseUri . $this->wsdlReportarEmergencia);
				
		$this->container->get('logger')->debug('reportarEmergencia');
        $key = new \SoapParam($this->key, 'key');
        $folio = new \SoapParam($params['folio'], 'folio');
        $longitud = new \SoapParam($params['longitud'], 'longitud');
        $latitud = new \SoapParam($params['latitud'], 'latitud');
        $fecha = new \SoapParam($params['fecha'], 'fecha');
        $placa = new \SoapParam($params['placa'], 'placa');
        $modelo = new \SoapParam($params['modelo'], 'modelo');
        $color = new \SoapParam($params['color'], 'color');
        $result = $soapClient->reportar($key, $folio, $longitud, $latitud, $fecha, $placa, $modelo, $color);
        $this->container->get('logger')->debug(sprintf("reportarEmergencia. result: '%s'", $result));
	        
        $estatus = new \SimpleXmlElement($result);
        
		return (string)$estatus;
	}
	
	/**
	 * Consulta estatus de emergencias reportadas. Los parámetros incluyen:
	 * folio: emergencia reportada de la que se quiere saber el estatus:
	 * tipo: 0 si se quiere saber el estatus de todas las emergencias o
	 * 1 si solo se quiere saber el estatus de emergencia identificada por
	 * el folio
	 * @param array $params
	 * @return array Estatus (puede ser un solo renglón)
	 */
	public function consultarStatus($params) 
	{
		$soapClient = new \SoapClient($this->baseUri . $this->wsdlConsultarStatus);
				
		$this->container->get('logger')->debug('consultarStatus');
        $key = new \SoapParam($this->key, 'key');
        $folio = new \SoapParam($params['folio'], 'folio');
        $tipo = new \SoapParam($params['consultarStatusActual']? '1': '0', 'tipo');
        $result = $soapClient->consultar($key, $folio, $tipo);
        $this->container->get('logger')->debug(sprintf("consultarStatus. result: '%s'", $result));
        
        $estatus = new \SimpleXmlElement($result);
        
        $resultado = array();
        $resultado['posiciones'] = array();
		$resultado['reporte'] = (string)$estatus['reporte'];
        
        $resultado['estatusActual'] = (string)$estatus['estatusactual'];
        
        if (isset($estatus->posicion) ) {
        	if ($estatus->posicion == 'Sin Resultados') 
        	{
        		$resultado['estatusActual'] = 'Sin Resultados';
        	} 
        	else 
        	{
        		foreach($estatus->posicion as $p)
        		{
        			$posicion = array();
        			$posicion['lat'] = $p->latitud;
        			$posicion['lng'] = $p->longitud;
        			$posicion['fecha'] = $p->fecha;
        			$posicion['estatus'] = $p->estatus;
        			$resultado['posiciones'][] = $posicion;
        		}
        	}
        }
         
        
		return $resultado;
	}
	
	public function __construct(Container $container, $key, $baseUri) 
	{
		$this->container = $container;
		$this->key = $key;
		$this->baseUri = $baseUri;
	}
	
}

?>