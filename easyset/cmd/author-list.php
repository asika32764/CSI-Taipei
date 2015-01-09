<?php
/**
 * Part of csi project. 
 *
 * @copyright  Copyright (C) 2015 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

$http = JHttpFactory::getHttp(null, 'curl');

$xml = <<<XML
<request xmlns="http://www.isinet.com/xrpc41" src="app.id=PartnerApp,env.id=PartnerAppEnv,partner.email=tingchiang@ntu.edu.tw">
	<fn name="LinksAMR.retrieve">
		<list>
			<map></map>
			<map>
				<list name="WOS">
					<val>timesCited</val>
					<val>sourceURL</val>
					<val>citingArticlesURL</val>
				</list>
			</map>
			<map>
				<map name="84857">
					<val name="doi">10.1109/LPT.2007.905661</val>
				</map>
			</map>
		</list>
	</fn>
</request>
XML;

$result = $http->post('https://ws.isiknowledge.com/cps/xrpc', $xml, array('Content-Type' => 'text/xml'));

print_r($result);

