<?php
namespace Scormi;

class MozApiAccess {
	public function __construct(){
	}

	public function getData($accessID, $secretKey, $objectURL, $timeout = 60){
		$data = get_transient('ScormiMozData', $data);

		if ( $data )
			return $data;

		// Set your expires for five minutes into the future.
		$expires = time() + 300;
		// A new linefeed is necessary between your AccessID and Expires.
		$stringToSign = $accessID."\n".$expires;
		// Get the "raw" or binary output of the hmac hash.
		$binarySignature = hash_hmac('sha1', $stringToSign, $secretKey, true);
		// We need to base64-encode it and then url-encode that.
		$urlSafeSignature = urlencode(base64_encode($binarySignature));

		// Add up all the bit flags you want returned.
		// Learn more here: http://apiwiki.seomoz.org/categories/api-reference
		$cols = 
			0 
	//		| 1						// Title					ut			The title of the page, if available
	//		| 4						// Canonical URL			uu			The canonical form of the URL
			| 32					// External Equity Links	ueid		The number of external equity links to the URL
	//		| 2048					// Links					uid			The number of links (equity or nonequity or not, internal or external) to the URL
			| 16384					// MozRank: URL				umrp umrr	The MozRank of the URL, in both the normalized 10-point score (umrp) and the raw score (umrr)
	//		| 32768					// MozRank: Subdomain		fmrp fmrr	The MozRank of the URL's subdomain, in both the normalized 10-point score (fmrp) and the raw score (fmrr)
	//		| 536870912				// HTTP Status Code			us			The HTTP status code recorded by Mozscape for this URL, if available
	//		| 34359738368			// Page Authority			upa			A normalized 100-point score representing the likelihood of a page to rank well in search engine results
			| 68719476736			// Domain Authority			pda			A normalized 100-point score representing the likelihood of a domain to rank well in search engine results
	//`		| 144115188075855872	// Time last crawled		ulc			The time and date on which Mozscape last crawled the URL, returned in Unix epoch format
		;


		$requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($objectURL)."?Cols=".$cols."&AccessID=".$accessID."&Expires=".$expires."&Signature=".$urlSafeSignature;
		// We can easily use Curl to send off our request.
		$options = array(
			CURLOPT_RETURNTRANSFER	=> true,
			CURLOPT_TIMEOUT			=> $timeout,
		);
		$ch = curl_init($requestUrl);
		curl_setopt_array($ch, $options);
		$content = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($content, true);
		if ( isset($data['error_message']) )
			throw new Exception('MozApiAccess: '.$data['error_message']);

		if ( ! $data )
			throw new Exception('MozApiAccess: No data returned from Moz or timeout');

		$data = array(
			'MozDomainAuthority'	=> $data['pda'],
			'MozExtLinks' 			=> $data['ueid'],
			'MozRank' 				=> $data['umrp'],
		);

		set_transient('ScormiMozData', $data, 3600);

		return $data;
	}
}
