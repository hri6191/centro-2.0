/*		Supporting Files:
		Js:jquery.js,query-ui.min.js
		Css:jquery-ui.css
		@author:arundev
*/
//<![CDATA[ 
$(function(){
var availableTags=new Array();	
var availableValues=new Array();
var xhr=null;	
function filterOptionsForResponse(select, term) {
	var matcher = new RegExp($.ui.autocomplete.escapeRegex(term), "i");
	var returnData = select.children("option").map(function() {
        var text = $(this).text();
        if (this.value && (!term || matcher.test(text))) return {
            label: text.replace(
            new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + $.ui.autocomplete.escapeRegex(term) + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<strong>$1</strong>"),
            value: text,
            option: this
        };
    }); 
    return returnData;
	
   
}
function updateOptions(select, searchResultData) {
    if ( !! searchResultData) {
        var givenOptions = select.children("option").map(function() {
            if ( !! this.value) return this.value.toLowerCase();
        });

        $.each(searchResultData, function(i, item) {
            if ($.inArray(item.name.toLowerCase(), givenOptions) == -1) select.append('<option value="' + item.name + '">' + item.name + '</option>');
        });
    }
}	
	function split( val ) {
		return val.split( /:\s*/ );
	}
	function extractLast( term ) {
			return split( term ).pop();
	}
$.widget("ui.combobox", {
		_create: function() {
        var input, self = this,
			availableTags=[],
            select = this.element.hide(),
            selected = select.children(":selected"),
			style=(select.attr('style')===undefined)?"1px solid #4682B4":select.attr('style'),
			placeholder=(select.attr('placeholder')===undefined)?'Search':select.attr('placeholder'),
			refer=select.attr('name'),
			myclass=(select.attr('class')===undefined)?'':select.attr('class'),
			myid=select.attr('id'),
			icon=(select.attr('title')===undefined)?'':select.attr('title'),
			tabindex=(select.attr('tabindex')===undefined)?'':select.attr('tabindex'),
            value = selected.val() ? selected.text() : "",
			allowMultiple=(select.attr('multiple')===undefined)?false:true,
            wrapper = $("<span>").addClass("ui-combobox").insertAfter(select); 
			icon=icon.replace(/\s/g, '');
			icon=icon.toLowerCase(); 
			if(icon=="showall"){
				if(wrapper.next('.search_button').length>0){
						wrapper.next('.search_button').hide();
					}
			} 
			$('#'+myid+' >option').each(function(){
												 		availableTags.push($(this).text());
														availableValues.push($(this).val());
												 });
        var cache = {}; 
        input = $('<input name="_'+refer+ '" id="_'+myid+'" placeholder="'+placeholder+'" style="'+style+'" value="'+value+'" tabindex="'+tabindex+'">').appendTo(wrapper).val(value).addClass("textbox").addClass(myclass).autocomplete({
            delay: 0,
            minLength: 0,
            source: function(request, response) {
                // implements retrieving and filtering data from the select
                var term = request.term;
				select.val(-1);
                if (term.length >= 3) {
                    var abbreviation = term.substring(0, 3);
                    if (!(abbreviation.toLowerCase() in cache)) {
                        cache[abbreviation.toLowerCase()] = 1;
                     
                    }
                }
				if(!allowMultiple){
               	 		if(select.attr('data-url')===undefined){response(filterOptionsForResponse(select, term));}
					else{ 
						var remote_url=select.attr('data-url');
						if(remote_url===undefined){}
						else{
							 if(term.length>=2){
								select.empty();
								if(xhr!=null)
									xhr.abort();
								xhr=$.ajax({
											dataType:'json',url:remote_url+'/'+term,type:'get',success: function(result){
												$.each(result,function(){
													select.append(new Option(this.name,this.id));
												});
												xhr=null;
												response(filterOptionsForResponse(select, term));
											}
									});
							}
						}
					}
					
				}
				else{
					response( $.ui.autocomplete.filter(
							availableTags, extractLast( request.term ) ) );
					var called=$('input[name="'+refer+'"]'); 
					if(called.length>0){
						var temp=$('input[name="_'+refer+'"]').val().split(':');
						newval="";
						if(temp.length>0){
							for(k=0;k<temp.length;k++){
								select.children("option").each(function() {
								if ($(this).text()==temp[k]) {
									index=$.inArray(temp[k],availableTags); 
									if(index!=-1){
										newval=newval+availableValues[index]+':';
									}
								}
							  });
							}
						}
						else{
								select.children("option").each(function() {
								if ($(this).text()==$('input[name="_'+refer+'"]').val()) {
									index=$.inArray(ui.item.value,availableTags); 
									if(index!=-1){
										newval=newval+availableValues[index]+':';
									}
								}
							  });
						}
						called.val(newval);
					}
				}
            },
			
            // end of input -> source
            select: function(event, ui) { 
                // implements first part of updating the select with the selection
/* 
                            Triggered when an item is selected from the menu;
                            ui.item refers to the selected item. 
                            The default action of select is to replace the text field's value with the value 
                            of the selected item.
                            */ 
				if(!allowMultiple){			
						ui.item.option.selected = true;
						self._trigger("selected", event, {
							item: ui.item.option
						}); 
				}
				else{ 
						var terms =split (this.value);
							// remove the current input
							terms.pop();
							// add the selected item
							terms.push( ui.item.value );
							// add placeholder to get the comma-and-space at the end
							terms.push( "" );
							this.value = terms.join( ": " );
							select.children("option").each(function() {
							if ($(this).text()==ui.item.value) {
								index=$.inArray(ui.item.value,availableTags); 
								if(index!=-1){
									var called=$('input[name="'+refer+'"]'); 
									if(called.length>0){
										var old=called.val();
										var newval='';
										if(old!="")	
											 newval=old+':'+availableValues[index];
										else
											newval=availableValues[index];
										called.val(newval);
									}
									else{
										select.after('<input type="hidden" name="'+refer+'" value="'+availableValues[index]+'">');
									}
								}
								return false;
                        	}
						});
							return false;
				} 
				if(select.attr('role')=='submit'){
					select.trigger('change');
				}
		},
		
            change: function(event, ui) { 
                //alert("changed");
                // implements second part of updating the select with the selection
				var valid=true;
				if(!allowMultiple){	
					if (!ui.item) {
						var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex($(this).val()) + "$", "i"),
							valid = false;
						select.children("option").each(function() {
							if ($(this).text().match(matcher)) {
								this.selected = valid = true;
								return false;
							}
						});
				}
			}
				else{
						var called=$('input[name="'+refer+'"]'); 
						if(called.length>0){
						var temp=$('input[name="_'+refer+'"]').val().split(':'); 
						newval="";
						if(temp.length>0){
							for(k=0;k<temp.length;k++){
								select.children("option").each(function() {
								if ($(this).text()==temp[k]) {
									index=$.inArray(temp[k],availableTags); 
									if(index!=-1){
										newval=newval+availableValues[index]+':';
									}
								}
							  });
							}
						}
						else{
								select.children("option").each(function() {
								if ($(this).text()==$('input[name="_'+refer+'"]').val()) {
									index=$.inArray(ui.item.value,availableTags); 
									if(index!=-1){
										newval=newval+availableValues[index]+':';
									}
								}
							  });
						}
						newval=newval.substring(0,newval.length-1);
						called.val(newval);
					}
				} 
					//check whether the data typed is remove or not based on class 
				if(!valid){
						if(myclass=="data_persist"){
							valid=true;
							if(valid){
								select.val(-1); 
							}
						}
					}
                    if (!valid) {
                        // remove invalid value, as it didn't match anything
                        $(this).val("");
                        select.val("");
                        input.data("autocomplete").term = "";
                        return false;
                    }
            } // end of input -> change
        }) // end of input -> autocomplete
        .addClass("ui-widget ui-widget-content ui-corner-left")
		.css({display:'block',border:'1px solid #4682B4'});
        input.data("autocomplete")._renderItem = function(ul, item) {
            // output the highlighting on each row
            return $("<li></li>").data("item.autocomplete", item).append("<a>" + item.label + "</a>").appendTo(ul);
        };
		if(icon!=""){ 
				icon=icon.replace(/\s/g, '');
				icon=icon.toLowerCase(); 
				if(icon=="showall"){
					 // Create a button that opens full list of options
					$("<a>").attr("tabIndex", -1).attr("title", "Show All Items").appendTo(wrapper).button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					}).removeClass("ui-corner-all").addClass("ui-corner-right ui-button-icon search-button").css({height:32}).click(function() {
						// close if already visible
						if (input.autocomplete("widget").is(":visible")) {
							input.autocomplete("close");
							return;
						}
			
						// work around a bug (likely same cause as #5265)
						$(this).blur();
			
						// pass empty string as value to search for, displaying all results
						input.autocomplete("search", "");
						input.focus();
					});
		}
	  }
    },
    // end of create()
    destroy: function() { 
		try{ 
       		 this.wrapper.remove();
		 }
		 catch(e){
			 }
        this.element.show();
        $.Widget.prototype.destroy.call(this);
    },
	
}); // end of calling widget
});//]]> 


