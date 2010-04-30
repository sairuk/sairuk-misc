<?php

		$item = $item['value'];

			/* Rom Types
			 * 
			 * [!]		Verified Good Dump
			 * [b		Bad Dump
			 * [f		Fixed
			 * [h		Hacked
			 * (Hack)	Hacked
			 * [o		Overdump
			 * [a		Alternate Dump
			 * (Unl)	Unlicensed
			 * (PD)		Public Domain
			 * (Beta)	Beta
			 * [T		Translation
			 * [t		Trained
			 * (Proto	Prototypes
			 * 
			 */
			# Dump Status
			$dumpstat = "";
		 	if (preg_match('/\[!\]/',$item)) { $dumpnum = "1";$dumpstat = "Verified Good Dump"; }
			if (preg_match('/\[b/',$item)) { $dumpnum = "25";$dumpstat = "Bad Dump"; }
			if (preg_match('/\[o/',$item)) { $dumpnum = "26";$dumpstat = "Overdump"; }
			
			# Dump Fix
			$dumpfix = "";
			if (preg_match('/\[a/',$item) || preg_match('/\(Alt\)/',$item)) { $fixnum = "21";$dumpfix = "Alternate Dump"; }	
			if (preg_match('/\[t/',$item)) { $fixnum = "22";$dumpfix = "Trained"; }
			if (preg_match('/\[f/',$item)) { $fixnum = "23";$dumpfix = "Fixed"; }
			if (preg_match('/\[h/',$item) || preg_match('/\Hack/',$item)) { $fixnum = "24";$dumpfix = "Hacked"; }
			
			# Dump Type
			if (preg_match('/\(Unl/',$item)) { $typenum = "16";$dumptype = "Unlicensed"; }
			else if (preg_match('/\(PD/',$item)) { $typenum = "17";$dumptype = "Public Domain"; }			 
			else if (preg_match('/\Beta/i',$item)) { $typenum = "18";$dumptype = "Beta";	}	
			else if (preg_match('/\(Proto/',$item)) { $typenum = "19";$dumptype = "Prototype";	}
			else if (preg_match('/\(Alpha/',$item)) { $typenum = "20";$dumptype = "Alpha"; }
			else { $dumptype = ""; }
			
			/* Region/Language
			 *  
			 * (G)		German
			 * (U)		USA
			 * (S)		Spanish
			 * (B)		Non-USA
			 * (E)		Europe
			 * (F)		France
			 * (A)		Australia
			 * (UE)		English
			 * (J)		Japan
			 * (W)		World
			 * (JUE)	World
			 * 
			*/

			# English Lang Codes
			if (preg_match('/\(U\)/',$item) || preg_match('/\(USA\)/',$item)) { $langnum = "2";$langlist = "USA"; }
			else if (preg_match('/\(E\)/',$item) || preg_match('/\(Europe\)/',$item)) { $langnum = "4";$langlist = "Europe";	}
			else if (preg_match('/\(W\)/',$item) || preg_match('/\(World\)/',$item)) { $langnum = "5";$langlist = "World"; }
			else if (preg_match('/\(A\)/',$item) || preg_match('/\(Australia\)/',$item)) { $langnum = "6";$langlist = "Australia"; }
			else if (preg_match('/\(UE\)/',$item) || preg_match('/\(USA, Europe\)/',$item)
			|| preg_match('/\(JU/',$item) || preg_match('/\(Japan, USA\)/',$item)) {
				 $langnum = "7";$langlist = "Multi-Region (English)";
			}
			# Non-English Lang Codes
			else if (preg_match('/\(J\)/',$item) || preg_match('/\(Japan\)/',$item)) { $langnum = "3";$langlist = "Japan"; }
			else if (preg_match('/\(S\)/',$item) || preg_match('/\(Spanish\)/',$item)) { $langnum = "8";$langlist = "Spanish"; }
			else if (preg_match('/\(B\)/',$item) || preg_match('/\(Brazil\)/',$item)) { $langnum = "9";$langlist = "Brazil";	}
			else if (preg_match('/\(F\)/',$item) || preg_match('/\(France\)/',$item)) { $langnum = "10";$langlist = "France";	}
			else if (preg_match('/\(G\)/',$item) || preg_match('/\(German\)/',$item)) { $langnum = "11";$langlist = "German";	}
			else { $langnum = "0";$langlist = ""; }
 
			#	Translations
			if (preg_match('/\[T-/',$item)) { $transnum = "15";unset($trenglist);$translist = "Translation Other Language (Old Version)";	}
			else if (preg_match('/\[T+/',$item)) { $transnum = "13";unset($trenglist);$translist = "Translation Other Language (Latest Version)";	}
			else if (preg_match('/\[T-Eng/i',$item)) { $transnum = "14";$translist = "Translation English (Old Version)";	}
			else if (preg_match('/\[T+Eng/i',$item)) { $transnum = "12";$translist = "Translation English (Latest Version)";	}	
			else { $transnum = "0";$translist = ""; }
?>