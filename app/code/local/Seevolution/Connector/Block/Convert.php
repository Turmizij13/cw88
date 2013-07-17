<?php
class Seevolution_Connector_Block_Convert extends Mage_Core_Block_Abstract {
	function _toHtml(){
		$active = Mage::getStoreConfig("connector/general/active");
		
		if ($active == "1"){
			$script = "  
				<!-- BEGIN: SeeVolution Conversion Page -->
			    <img alt='' width='0'' height='0' src='https://c.svlu.net/pixel.aspx'/>
			    <script type='text/javascript'>
			    svluArea='Conversion';
			    (function()
			      {
			        var ms = document.createElement('script');
			        var site = ('https:' == document.location.protocol) ? 'https://c.svlu.net/cjs.aspx' : 'http://c.svlu.net/cjs.aspx';
			        ms.src = site;
			        ms.setAttribute('async', 'true');
			        document.documentElement.firstChild.appendChild(ms);
			      })();
			    </script>
			    <!-- END: SeeVolution Conversion Page -->";
				
			return $script;
		}
		else{
			return "";
		}
	}
}
