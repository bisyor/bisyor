<?php 
    function file_get_contents_curl($url){
        $arrContextOptions = stream_context_create([
            "ssl"=>[
                "verify_peer"   =>  false,
                "verify_peer_name"  =>  false,
            ],
        ]); 
        return file_get_contents($url , false , $arrContextOptions);
    }
    
    
    function get_headers_curl($url){
        $arrContextOptions = stream_context_create([
            "ssl"=>[
                "verify_peer"   =>  false,
                "verify_peer_name"  =>  false,
            ],
        ]); 

        return get_headers($url , 1 , $arrContextOptions);
    }

?>