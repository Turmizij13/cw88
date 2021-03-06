<?php
class Seevolution_Connector_Block_Connector extends Mage_Core_Block_Abstract {
	function _toHtml(){
		$active = Mage::getStoreConfig("connector/general/active");
		
		if ($active == "1"){
			$script = "  
				<!-- BEGIN: SeeVolution -->
			    <script type='text/javascript'>
			    (function()
			      {
			        var ms = document.createElement('script');
			        var site = ('https:' == document.location.protocol) ? 'https://c.svlu.net/cjs.aspx' : 'http://c.svlu.net/cjs.aspx';
			        ms.src = site;
			        ms.setAttribute('async', 'true');
			        document.documentElement.firstChild.appendChild(ms);
			      })();
			    </script>
			  	<!-- END: SeeVolution -->";
			
			return $script;
		}
		else{
			return "";
		}
	}
}
