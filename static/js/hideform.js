function addLoadEvent(func) 
{
	var oldonload = window.onload;
	if (typeof window.onload != 'function') 
	{
		window.onload = func;
	} 
	else 
	{
		window.onload = function() 
		{
			oldonload();
			func();
		}
	}
}

addLoadEvent(process_form);

function process_form()
{
	process_elements_input($("input.hide-me"));
	process_element_texarea($("textarea.hide-me"));
	process_element_select($("select.hide-me"));
}

function process_elements_input(eles)
{
	for (var idx = 0; idx < eles.length; idx++) 
	{
		if (eles[idx].nodeType != 1)
			continue;

		var eles_type = eles[idx].getAttribute("type");
		
		// we want to re-create the input (text) value into a paragraph tag
		if (eles_type == "text") 
		{
			var new_ele_ref 	= document.createTextNode(eles[idx].value);
			$(eles[idx]).parent().append("<p>"+eles[idx].value+"</p>");
	
		}
		else if ((eles_type == "radio") || (eles_type == "checkbox"))
		{
			var parent_ref = eles[idx].parentNode;
			if (parent_ref.nodeName == "LABEL")
			{
				if (eles[idx].checked == true)
					parent_ref.setAttribute("class", "print_disp_on");
				else
					parent_ref.setAttribute("class", "print_disp_off");
			}
			else
			{
				if (eles[idx].checked == true)
				{
					var new_ele_ref 	= document.createTextNode("X ");
				}
				else
				{
					var new_ele_ref 	= document.createTextNode(" ");
				}
				eles[idx].parentNode.insertBefore(new_ele_ref, eles[idx].nextSibling);		
			}

		}

	}
}

function process_element_texarea(eles)
{
	for (var idx = 0; idx < eles.length; idx++) 
	{
		var new_ele_ref 	= document.createElement('fieldset');
		var new_ele_ref1 	= document.createElement('span');
		new_ele_ref1.setAttribute("class", "print_disp_on");
		new_ele_ref.appendChild(new_ele_ref1);

		var eles_text_ref 	= document.createTextNode(eles[idx].value);
		new_ele_ref.appendChild(eles_text_ref);

		eles[idx].parentNode.insertBefore(new_ele_ref, eles[idx].nextSibling);
	}
}

function process_element_select(eles)
{
	for (var idx = 0; idx < eles.length; idx++) 
	{
		if (eles[idx].value)
		{
			var sIndex 		= eles[idx].selectedIndex;
			var select_text = eles[idx].options[sIndex].text;

			$(eles[idx]).parent().append("<p>"+select_text+"</p>");
		}
	}
}