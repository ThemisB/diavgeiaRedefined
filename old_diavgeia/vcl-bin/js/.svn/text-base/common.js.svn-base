function isdefined(object, variable)
{
        return (typeof(eval(object)[variable]) != 'undefined');
}

function findObj(id,thedoc)
{
    var f, k;

    if (!thedoc) thedoc=document;

    if (thedoc.all)
    {
        f=thedoc[id];
        if (f) return(f);
    }

    for (k=0;k<thedoc.forms.length;k++)
    {
        f=thedoc.forms[k][id];
        if (f) return(f);
    }

    if (thedoc.layers)
    {
        for(k=0;k<thedoc.layers.length;k++)
        {
            f=findObj(id,thedoc.layers[i].document);
            if (f) return(f);
        }
    }

    if (thedoc.getElementById)
    {
        f=thedoc.getElementById(id);
        return(f);
    }
}

function showLayer(layername,event)
{
        layer=findObj(layername);
        l=event.clientX+document.body.scrollLeft+40;
        t=event.clientY+document.body.scrollTop-100;
        layer.style.left=l.toString()+"px";
        layer.style.top=t.toString()+"px";
        layer.style.visibility="visible";
}

function hideLayer(layername)
{
        layer=findObj(layername);
        layer.style.visibility="hidden";
}


function toJSON(xa)
{
    var m = {
            '\b': '\\b',
            '\t': '\\t',
            '\n': '\\n',
            '\f': '\\f',
            '\r': '\\r',
            '"' : '\\"',
            '\\': '\\\\'
        };

        s = {
            array: function (x) {
                var a = ['['], b, f, i, l = x.length, v;
                for (i = 0; i < l; i += 1) {
                    v = x[i];
                    f = s[typeof v];
                    if (f) {
                        v = f(v);
                        if (typeof v == 'string') {
                            if (b) {
                                a[a.length] = ',';
                            }
                            a[a.length] = v;
                            b = true;
                        }
                    }
                }
                a[a.length] = ']';
                return a.join('');
            },
            'boolean': function (x) {
                return String(x);
            },
            'null': function (x) {
                return "null";
            },
            number: function (x) {
                return isFinite(x) ? String(x) : 'null';
            },
            object: function (x) {
                if (x) {
                    if (x instanceof Array) {
                        return s.array(x);
                    }
                    if (!x.json)
                    {
                    x.json=1;
                    var a = ['{'], b, f, i, v;
                    for (i in x) {
                        v = x[i];
                        f = s[typeof v];
                        if (f) {
                            v = f(v);
                            if (typeof v == 'string') {
                                if (b) {
                                    a[a.length] = ',';
                                }
                                a.push(s.string(i), ':', v);
                                b = true;
                            }
                        }
                    }
                    a[a.length] = '}';
                    return a.join('');
                    }
                }
                return 'null';
            },
            string: function (x) {
                if (/["\\\x00-\x1f]/.test(x)) {
                    x = x.replace(/([\x00-\x1f\\"])/g, function(a, b) {
                        var c = m[b];
                        if (c) {
                            return c;
                        }
                        c = b.charCodeAt();
                        return '\\u00' +
                            Math.floor(c / 16).toString(16) +
                            (c % 16).toString(16);
                    });
                }
                return '"' + x + '"';
            }
        };

        return(s.object(xa));
};

String.prototype.parseJSON = function () {
    try {
        return !(/[^,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t]/.test(
                this.replace(/"(\\.|[^"\\])*"/g, ''))) &&
            eval('(' + this + ')');
    } catch (e) {
        return false;
    }
};



       function dumpObj(obj, name, indent, depth) {

              if (depth > 10) {

                     return indent + name + ": <Maximum Depth Reached>\n";

              }

              if (typeof obj == "object") {

                     var child = null;

                     var output = indent + name + "\n";

                     indent += "\t";

                     for (var item in obj)

                     {

                           try {

                                  child = obj[item];

                           } catch (e) {

                                  child = "<Unable to Evaluate>";

                           }

                           if (typeof child == "object") {

                                  output += dumpObj(child, item, indent, depth + 1);

                           } else {

                                  output += indent + item + ": " + child + "\n";

                           }

                     }

                     return output;

              } else {

                     return obj;

              }

       }