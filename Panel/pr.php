<?

var_dump(MatchName('h3lLl0bOys'));


								function MatchName($str){
									$value = $str;
									$str = mb_strlen(preg_replace('/\[^\d]/si', '', $str));
										if($str >1){
											if(preg_match('/(?=.*([a-z].*?[a-z]))(?=.*([A-Z].*?[A-Z]))/', $value)>0){
												return true;
											} else {
												return false;
											}
										} else {
											return false;
										}
									}
?>