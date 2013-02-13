function AjaxConnection(url) 
{
   this.connect=connect;
   this.uri=url;
} 


function connect(return_func, params, method)
{
	this.x=init_object();
        this.x.open(method, this.uri,true);
        var self = this;
        this.x.onreadystatechange = function() {
        	if (self.x.readyState != 4)
                	return;
                //self.x.setAttribute("responseText", return_func);
                eval(return_func + '(self.x.responseText)');
                delete self.x;
        }
        this.x.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        this.x.send(params);
}


function abortAjax()
{	
        this.x.abort();
}

function init_object() {
        var x;
        try {
                x=new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
                try {
                        x=new ActiveXObject("Microsoft.XMLHTTP");
                } catch (oc) {
                        x=null;
                }
        }      
        if(!x && typeof XMLHttpRequest != "undefined")
                x = new XMLHttpRequest();
        if (x)
                return x;
}
