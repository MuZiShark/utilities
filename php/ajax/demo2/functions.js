CWS3  x��SMO�@;�1J���
�=�b��h"�BAH���CU���!�����М{h/��R���z��W:�6$QSՖ�;owf޼�0]x�������\)�����Qp(#}�m�\_��،���{��Cy��!ľ4Aϥ
>��"A�������Hp�?������ط�� `�i�*�z���

6z��}q�n��>�� N���u ���(ۀFcm4B$M�1�G�	0�`4eq:����k�6� !�M�� �%��;�s�x�恇II�<8�G�zQ;���.w��>�]j_H�� nu]7�S���E_ɖʨ8b��"ܴ�&�¸mu��i�V�j!N}aE���"H�����AD8�$>��Ui�)�oH&�����`h�$��9���e	��^>���C��+'(h�kL�̤w {���}�5�j�w��ơ\'[r�ڗ9:*G��h�+�D,�:(Z�q�����G�X3�#�t�D!�g�4�o�,�L���i�I�D6wC��j�B?��FQ��3��/^\͍N<Ⱥ�B���Ƭ*�t��s87�g��as���Z�5�U�#AD�Z������2����NTyE����af�Rz�ͳ���B.�1�$fڍ�����j4��C�f���V+L�-f��iD�G��2�Q�U��S�&X�P����rxܪ&�`���O��Zk�*�+�YI�{�2�����8                                                                                                                                                                                                                                                                                                         
	
	addObject.style.visibility = "hidden";
	addObject.style.height = "0px";
	addObject.style.width = "0px";
}

function findPosX(obj)
{
	var curleft = 0;
	
	if(obj.offsetParent)
	{
		while(obj.offsetParent)
		{
			curleft += obj.offsetLeft;
			obj = obj.offsetParent;
		}
	}
	else if(obj.x)
	{
		curleft += obj.x;
	}
	return curleft;
}

function findPosY(obj)
{
	var curtop = 0;
	
	if(obj.offsetParent)
	{
		while(obj.offsetParent)
		{
			curtop += obj.curTop;
			obj = obj.offsetParent;
		}
	}
	else if(obj.y)
	{
		curtop += obj.y;
	}
	return curtop;
}

function autocomplete(thevalue, e)
{
	theObject = document.getElementById("autocompletediv");
	
	theObject.style.visibility = "visible";
	theObject.style.width = "152px";
	
	var posx = 0;
	var posy = 0;
	
	posx = (findPosX(document.getElementById("yourname"))+1);
	posy = (findPosY(document.getElementById("yourname"))+23);
	
	theObject.style.left = posx + "px";
	theObject.style.top = posy + "px";
	
	var theextrachar = e.which;
	
	if(theextrachar == undefined)
	{
		theextrachar = e.keyCode;
	}
	
	
	//Ҫ�����ҳ���λ�á�
	var objID = "autocompletediv";
	
	//�����˸��
	if(theextrachar == 8)
	{
		if(thevalue.length == 1)
		{
			var serverPage = "autocomp.php"
		}
		else
		{
			var serverPage = "autocomp.php" + "?sstring=" + thevalue.substr(0, (thevalue.length-1));
		}
	}
	else
	{
		var serverPage = "autocomp.php" + "?sstring=" + thevalue + String.formCharCode(theextrachar);
	}
	
	var obj = document.getElementById(objID);
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			obj.innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.send(null);	
}

function setvalue(thevalue)
{
	acObject = document.getElementById("autocompletediv");
	
	acObject.style.visibility = "hidden";
	acObject.style.height = "0px";
	acObject.style.width = "0px";
	
	document.getElementById("yourname").value = thevalue;
}















