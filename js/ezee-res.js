var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
                    var eventer = window[eventMethod];
                    var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";

                    // Listen to message from child window
                    eventer(messageEvent,function(e) {
                    console.log("parent received message!:  ",e.data);
                        
                         if (typeof(e.data.action)!="undefined") {                    
                            if(e.data.action=="TOP")
                            {
                               var frametop= (jQuery("#editframe").position().top);
                                var divtop=e.data.top;
                                if(parseInt(frametop) > parseInt(divtop))
                                    var f_h=parseInt(frametop)-parseInt(divtop)+400;
                                else
                                    var f_h=divtop;
                                //console.log(f_h);
                                jQuery(window).scrollTop(f_h);
                            }
                        }
                        
                    jQuery(".editframe").height(e.data+10);
},false);