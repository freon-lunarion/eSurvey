<?php

/* 
	TWITTER BOOTSTRAP v2.0 - HELPER
	Author: James Rainaldi
	Created: 2012-02-03
	Modified: 2012-02-21
	Version: v1.0.3
	Contributors: .....

 */

	/*
	FORMS
	Description:
	This helper file assists in creating the twitter bootstrap v2.0 elements (control-groups) in 
	  combination with the codeigniter form helper.
	*/




	/**
	 * Generates an control-group structure.
	 *
	 * @param   String  label name
	 * @param   String/array   html elements (use Codginiter Form Helper)
	 * @param		Array   twitter bootstrap specific attributes and control-group html attrs validation: error, success, warning
	 * @return  String
	 */
	function control_group($label_name = NULL, $element, $attr = NULL)
	{
		//Declare and Initialize variables
		$cg_str='';
		
		//Basic HTML element attributes
		$attr['id']    = (isset($attr['id']))?$attr['id']:'';
		$attr['class'] = (isset($attr['class']))?$attr['class']:'';
		$attr['style'] = (isset($attr['style']))?$attr['style']:'';
				
		//Twitter Bootstrap attributes
		$attr['validation']  = (isset($attr['validation']))?$attr['validation']:NULL;
		$attr['help-inline'] = (isset($attr['help-inline']))?$attr['help-inline']:NULL;
		$attr['help-block']  = (isset($attr['help-block']))?$attr['help-block']:NULL;
		$attr['uneditable']  = (isset($attr['uneditable']))?TRUE:FALSE;
		$attr['view']        = (isset($attr['view']))?TRUE:FALSE;
		
		//Append/Prepend Elements
		if((isset($attr['prepend']))):
			$attr['prepend'] = $attr['prepend'];
		else :
			$attr['prepend'] = NULL;
		endif;
		if((isset($attr['append']))):
			$attr['append'] = $attr['append'];
		else :
			$attr['append'] = NULL;
		endif;

		//Set the prepend/append checkbox status if it is checked by default		
		$attr['add-on-class'] = ((isset($attr['prepend']) and strpos($attr['prepend'],'checked')!==FALSE) or (isset($tb_attributes['append']) and strpos($tb_attributes['append'],'checked')!==FALSE))
									 ?'active'
									 :'';

		//Assign the label 'for' attribute to the first element's ID value for
		// label click functionality.
		if(is_array($element)):
			foreach($element as $e):
				$element_id[] = substr(substr($e,strpos($e,'id=')+4),0,strpos(substr($e,strpos($e,'id=')+4),'"'));
			endforeach;
		else :	
			$element_id[] = substr(substr($element,strpos($element,'id=')+4),0,strpos(substr($element,strpos($element,'id=')+4),'"'));
		endif;		
		
		//Begin generating the control-group structure
		$cg_str .= '<div id="'.$attr['id'].'" class="control-group '.$attr['class'].' '.$attr['validation'].' clearfix" style="'.$attr['style'].'" >';
		  $cg_str .= '<label class="control-label" for="'.$element_id[0].'">'.$label_name.'</label>';
		  $cg_str .= '<div class="controls">';
		    
				//Create prepend/append div
				if(isset($attr['prepend']))
					$cg_str .= '<div class="input-prepend ">';
				else if(isset($attr['append'])):
					$cg_str .= '<div class="input-append ">';
				endif;
				
					//Add prepend element
					if(isset($attr['prepend'])):
						$cg_str .= '<span class="add-on '.$attr['add-on-class'].'">'.$attr['prepend'].'</span>';
					endif;
					
					//Add elements 
					// Check if element variable passed is an array or string
					if(is_array($element)):
						foreach($element as $e):
							$cg_str .= ($attr['uneditable'] or $attr['view']) ? '<span class="'. ($attr['view'] ? "view-input" : ($attr['uneditable'] ? "uneditable-input" : "")) .'">'.$e.'</span>' : $e;
						endforeach;
					else :
						$cg_str .= ($attr['uneditable'] or $attr['view']) ? '<span class="'. ($attr['view'] ? "view-input" : ($attr['uneditable'] ? "uneditable-input" : "")) .'">'.$element.'</span>' : $element;
					endif;

					//Add append element
					if(isset($attr['append'])):
						$cg_str .= '<span class="add-on '.$attr['add-on-class'].'">'.$attr['append'].'</span>';
					endif;

				
					//Add Help-inline text
					if(isset($attr['help-inline'])): 
						$cg_str .= '<span class="help-inline">'.$attr['help-inline'].'</span>';
					endif;
				
				//Close append/prepend div
				if(isset($attr['prepend']) or isset($attr['append'])):
					$cg_str .= '</div>';
				endif;

				//Add Help-block text
				if(isset($attr['help-block'])): 
					$cg_str .= '<p class="help-block">'.$attr['help-block'].'</p>';
				endif;
				
		  $cg_str .= '</div> <!-- END OF .controls -->';
		$cg_str .= '</div> <!-- END OF .control-group -->';
		
		return $cg_str;
	} //END OF control_group function


	/**
	 * Generates a form-action box.
	 *
	 * @param   String  label name
	 * @param   String/Array   html button/submit elements (use Form Helper)
	 * @param		Array   twitter bootstrap specific attributes (error, append, prepend, etc.)
	 * @return  String
	 */
	function form_action($button, $attr = NULL)
	{
			
		//Declare and Initialize variables
		$fa_str='';
		$array_count=0;
		
		//Basic HTML element attributes
		//$button = (isset($button)) ? $button : '';

		$attr['id'] = (isset($attr['id']))?$attr['id']:'';
		$attr['class'] = (isset($attr['class']))?$attr['class']:'';
		$attr['style'] = (isset($attr['style']))?$attr['style']:'';
			
		$fa_str = '<div id="'.$attr['id'].'" class="form-actions '.$attr['class'].' " style="'.$attr['style'].'" >';
		
			if(is_array($button)):
				foreach($button as $b):
					$fa_str .= ($array_count>0)?'&nbsp;'.$b:$b;
					$array_count++;
				endforeach;
			else :	
				$fa_str .= $button;
			endif;
		
		$fa_str .= '</div>';
		
		return $fa_str;
	} //END OF form_action function



/* ************************************************************************* */

/*
ALERTS
Description:
This helper file assists in creating the twitter bootstrap v2.0 alert elements (alert).
*/

	function alert($body, $attr=NULL){

		//Declare and Initialize variables
		$alert_str='';
		$array_count=0;
		
		//Basic HTML element attributes
		$attr['id'] = (isset($attr['id']))?$attr['id']:'';
		$attr['class'] = (isset($attr['class']))?$attr['class']:'';
		$attr['style'] = (isset($attr['style']))?$attr['style']:'';
		$attr['dismissal'] = (isset($attr['dismissal']) and $attr['dismissal']===TRUE)?TRUE:FALSE;
		$attr['header'] = (isset($attr['header']))?$attr['header']:NULL;

		$alert_str = '<div id="'.$attr['id'].'" class="alert '.$attr['class'].' fade in " style="'.$attr['style'].'" >';
			
			if($attr['dismissal']):
				$alert_str .= '<a class="close" data-dismiss="alert" href="#">×</a>';
			endif;
			
			//Add header
			if(isset($attr['header'])):
				$alert_str .= '<h4 class="alert-heading">'.$attr['header'].'</h4>';
			endif;
			
			//Add body
			$alert_str .= $body;
			
		
		$alert_str .= '</div>';

		return $alert_str;

	}  //END OF alert function


/*
Buttons
Description:
This helper file assists in creating the twitter bootstrap v2.0 button componenets.
*/

	/*
	BUTTON GROUP (non-dropdown)
	Description:
	This helper file assists in creating the twitter bootstrap v2.0 alert elements (alert).
	*/

		function button_group($button = '', $attr=NULL){

			//Declare and Initialize variables
			$bg_str='';
			$array_count=0;
			
			//Basic HTML element attributes
			$attr['id'] = (isset($attr['id']))?$attr['id']:'';
			$attr['class'] = (isset($attr['class']))?$attr['class']:'';
			$attr['style'] = (isset($attr['style']))?$attr['style']:'';
			$attr['toggle'] = (isset($attr['toggle'])) ? 'buttons-'.$attr['toggle'] : '' ;
				
				if(is_array($button)):

					if(is_array($button[0])):

						$bg_str .= '<div class="btn-toolbar" id="'. $attr['id'] .'" class="'. $attr['class'] .'" style="'. $attr['style'] .'" >';

						foreach($button as $b):

							$bg_str .= '<div class="btn-group" data-toggle="'. $attr['toggle'] .'" >';
							
							foreach($b as $b2):
								$bg_str .= $b2;
							endforeach;

							$bg_str .= '</div >';

						endforeach;	

						$bg_str .= '</div>';

					else:
						$bg_str .= '<div class="btn-group" data-toggle="'. $attr['toggle'] .'" >';

						foreach($button as $b):
							$bg_str .= $b;							
						endforeach;

						$bg_str .= '</div>';

					endif;	

				else :
						$bg_str .= $button;
				endif;						

			return $bg_str;

		}  //END OF button_group function

	/*
	BUTTON GROUP (non-dropdown)
	Description:
	This helper file assists in creating the twitter bootstrap v2.0 alert elements (alert).
	*/
	function button_dropdown($data = '', $content = '', $extra = ''){
		$btn_str = '';
		$is_dropdown = $is_split = FALSE;
		$defaults = array('name' => (( ! is_array($data)) ? $data : ''), 'type' => 'button');

		if ( is_array($data) AND isset($data['content']))
		{
			$content = $data['content'];
			unset($data['content']); // content is not an attribute
		}
		if ( is_array($data) AND isset($data['class']))
		{
			$data['class'] = 'btn ' . $data['class'];
		}

		if ( is_array($data) AND isset($data['toggle']))
		{
			$toggle = ($data['toggle']==='button') ? "data-toggle='" . $data['toggle'] ."'" : '';
		}else {
			$toggle = "";
		}
		if ( is_array($data) AND isset($data['loading-text']))
		{
			$loading_text = "data-loading-text='" . $data['loading-text'] ."'";
		}else {
			$loading_text = "";
		}
		if ( is_array($data) AND isset($data['complete-text']))
		{
			$complete_text = "data-complete-text='" . $data['complete-text'] ."'";
		}else {
			$complete_text = "";
		}
		if ( is_array($data) AND isset($data['split']) )
		{	
			$is_split = TRUE;
		}
		if ( is_array($data) AND isset($data['dropup']) AND $data['dropup']===TRUE)
		{
			$dropup = "dropup";
		}else {
			$dropup = "";
		}

		$btn_str .= '<div class="btn-group ' . $dropup . '"  >';

		if($is_split){
			$btn_str .= "<button "._parse_form_attributes($data, $defaults).$extra." " . $toggle . " " . $loading_text ." " . $complete_text ." >".$content."</button>";
			$btn_str .= '<button class="btn dropdown-toggle '. $data['class'] .'" data-toggle="dropdown"><span class="caret"></span></button>';
		}else {
			$data['class'] .= ' dropdown-toggle';
			$btn_str .= "<button "._parse_form_attributes($data, $defaults).$extra." " . $toggle . " " . $loading_text ." " . $complete_text ." data-toggle='dropdown' >".$content." <span class='caret'></span></button>";
		}


		if ( is_array($data['options']) AND isset($data['options'] ) or is_array($extra['options']) AND isset($extra['options'] ))
		{	
			$btn_str .= '<ul class="dropdown-menu">';
			foreach($data['options'] as $r):
				$btn_str .= ($r === 'divider') ? '<li class="divider" ></li>' : '<li>' . $r . '</li>';
			endforeach;
			$btn_str .= '</ul>';
		}

		$btn_str .= '</div> <!-- End of .btn-group -->';


		return $btn_str;

	}  //END OF button_group function
	/* 
	Add on Secttion 
	Author: Antonio Daniswara
	Created: 2013-06-07
	Modified: 2013-06-07
 	*/
	/*
	PAGE HEADER 
	Description:
	Helper ini berfungsi untuk membuat judul (title) dan sub judul (subtitle) halaman.
	*/
	function page_header($title='',$subtitle='')
	{
		$result = '<div class="page-header">';
		$result.= '<h1>'.$title.' <small>'. $subtitle.'</small></h1>';
		$result .='</div>';
		return $result;
	}
	/*
	NAV TAB 
	Description:
	Helper ini berfungsi untuk membuat navigasi tab.
	*/
	function nav_tab($array = array(),$attr=NULL)
	{
		$result = '';
		if (isset($attr['direction']) && ($attr['direction']=='left' OR $attr['direction']=='right' OR $attr['direction']=='below'))
		{
			'<div class="tabbable tabs-'.$attr['direction'].'">';
		}
		$result.='<ul class="nav nav-tabs">';
		$flag = 0;
		foreach ($array as $key => $value) {
			if ($flag==0)
			{
				$result.='<li class="active">';	
				$flag=1;
			}
			else
			{
				$result.='<li>';	
			}
			$result.='<a href="#'.$key.'" data-toggle="tab">'.$value.'</a></li>';
		}

		$result.='</ul>';

		if (isset($attr['direction']))
		{
			'</div>';
		}
		return $result;
	}
	/*
	accordion_group_open
	Description:
	Helper ini berfungsi untuk syntax html pembuka untuk tampilan accordion.
	*/
	function accordion_group_open($parent_id='',$id='',$text='',$is_active=FALSE)
	{
		$result ='';
		$result.='<div class="accordion-group">';
		$result.='<div class="accordion-heading">';
		$result.='<a class="accordion-toggle" data-toggle="collapse" data-parent="#'.$parent_id.'" href="#'.$id.'">';
		$result.=$text.'</a>';
		$result.='</div><!-- accordion-heading -->';
		if ($is_active==TRUE)
		{
			$result.='<div style="height: auto;" id="'.$id.'" class="accordion-body in collapse">';
		}
		else
		{
			$result.='<div style="height: 0px;" id="'.$id.'" class="accordion-body collapse">';
		}
		$result.='<div class="accordion-inner">';
		return $result;
	}
	/*
	accordion_group_close
	Description:
	Helper ini berfungsi untuk syntax html menutup untuk tampilan accordion. Berpasangan dengan accordion_group_open
	*/
	function accordion_group_close()
	{
		$result ='</div><!-- accordion-inner-->';
		$result.='</div><!-- style-->';
		$result.='</div><!-- accordion-group -->';
		return $result;
	}
	/*
	modal_trigger_button
	Description:
	Berfungsi untuk membuat tombol untuk popup model bootstrap. 
	*/
	function modal_trigger_button($modal_id= '', $text ='Click Here',$attribut='')
	{
		$result = '<a href="#'.$modal_id.'" role="button" class="btn '.$attribut.'" data-toggle="modal">'.$text.'</a>';

		return $result;
	}
	/*
	modal_box
	Description:
	Berfungsi untuk membuat tombol untuk popup model bootstrap. 
	*/
	function modal_dialog($modal_id= '',$header='',$content='',$btn_close='Close',$btn_primary='Save')
	{
		$result ='<div id="'.$modal_id.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
		$result.='<div class="modal-header">';
		$result.='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
		$result.='<h3 id="'.$modal_id.'Label">'.$header.'</h3></div>';
		$result.='<div class="modal-body">';
		if (strpos($content,'<p>')==FALSE)
		{
			$result.='<p>'.$content.'</p>';
		}
		else
		{
			$result.=$contenct;
		}
		$result.='</div>';
		$result.='<div class="modal-footer">';
		$result.='<button class="btn" data-dismiss="modal" aria-hidden="true">'.$btn_close.'</button>';
		$result.='<button class="btn btn-primary">'.$btn_primary.'</button>';
		$result.='</div></div>';

		return $result;
	}
	/*
	Breadcrumb
	Description:
	Helper ini berfungsi untuk menampilkan bar posisi halaman yang aktif dari halaman-halaman yang berangkai. 
	*/
	function breadcrumb($array_list=array(),$active_index=0)
	{
		$result ='<ul class="breadcrumb">';
		$max = count($array_list);
		for ($i=0; $i < $max; $i++) { 
			if ($i==$active_index)
			{
				$result.='<li class="active">';
			}
			else
			{
				$result.='<li>';
			}

			if( $i!=$active_index &&(isset($array_list[$i]['link'])==FALSE OR $array_list[$i]['link']==''))
			{
				$result.='<a href="#">'.$array_list[$i]['text'].'</a>';
			}
			else if($i!=$active_index &&(isset($array_list[$i]['link'])==TRUE && $array_list[$i]['link']!=''))
			{
				$result.=anchor($array_list[$i]['link'],$array_list[$i]['text']);
			}
			else
			{
				$result.= $array_list[$i]['text'];
			}

			if ($i!=($max-1))
			{
				$result.=' <span class="divider">/</span>';
			}
			$result.='</li>';
		}
		$result.='</ul>';
		return $result;
	}

	/*
	carousel
	Description:
	Helper ini berfungsi untuk membuat carosel atau slidephoto dengan keterangan. 
	*/
	function carousel($id='myCarousel',$content_list=array())
	{
		$max_content = count($content_list);
		$result ='<div id="'.$id.'" class="carousel slide">';
		$result.='<ol class="carousel-indicators">';
		for($i=0;$i<$max_content;$i++)
		{
			if ($i==0)
			{
				$result.='<li data-target="#'.$id.'" data-slide-to="'.$i.'" class="active"></li>';
			}
			else
			{
				$result.='<li data-target="#'.$id.'" data-slide-to="'.$i.'" class=""></li>';
			}
		}
		$result.='</ol>';
		$result.='<div class="carousel-inner">';
		for ($i=0; $i <$max_content ; $i++) 
		{ 
			if ($i==0)
			{
				$result.='<div class="item active">';
			}
			else
			{
				$result.='<div class="item">';
			}
			$result.=img($content_list[$i]['image']);

			$result.='<div class="carousel-caption">';
			$result.='<h4>'.$content_list[$i]['title'].'</h4>';
			$result.='<p>'.$content_list[$i]['desc'].'</p>';
			$result.='</div><!-- end of carousel-captio -->';
			$result.='</div><!-- end of item -->';

		}		
		$result.='</div><!-- end of carosel-inner -->';
		$result.='<a class="left carousel-control" href="#'.$id.'" data-slide="prev">‹</a>';
		$result.='<a class="right carousel-control" href="#'.$id.'" data-slide="next">›</a>';
		$result.='</div><!-- end of carosel slide -->';
		return $result;
	}
?>