$(function() {
//Let's set up some shit
	var output 		=	$('#output'),
		snippets 	= 	$('#snippets'),
		message 	= 	$('#message'),
		gimme		=	$('#gimme'),
		reset		= 	$('#reset'),
		app			=	$('#application');
		
	$(snippets).hide();
	$(output).fadeTo(0, 0.0)

//Let's work out what people want
	$(app).find('article').click(function(){
		$(this).toggleClass('yo no');
	});

//Select everything
	$('#all').click(function(){
		$(app).find('article').removeClass('no').addClass('yo');
	});

//...and then give it to them
	$(gimme).click(function(){
		var quantity = $('article.yo').length;
		if(quantity > 0){
			$(output).text('').append('&#60;?php ');
			$(app).find('article.yo').each(function(){
				var thisSnippet = '#' + $(this).data('snippet');
				var wantedCode = $(snippets).find(thisSnippet).html();
				$(output).append(wantedCode)
						 .animate({'height':'200px', 'opacity':'1.0'},'fast');
			});
			$(output).append('?&#62;');
		}
		else {
			$(message).find('h1').text('Ohhh no!');
        	$(message).find('p').text('Sorry, but you need to select at least one snippet!');
 			$(message).fadeIn(500)
		}
	});
	
//Click handler for our reset button
	$(reset).click(function(){
		$(output).animate({'height':'0px', 'opacity':'0.0'},'fast');
		$(app).find('article').removeClass('yo').addClass('no');
	});
	

//when you click on the code it will select everything
	$(output).click(function(){ 
 		$(this).focus().select();
	});

//first time the user copies thier selection thank them for using the service!
	$(output).one('copy', function(){
        $(message).find('h1').text('Thanks for useing WPFunction.Me');
        $(message).find('p').text('Go ahead and paste this code into your functions.php file in your theme.');
 		$(message).fadeIn(500)
	});

//remove the message layer if the user clicks anywhere
	$(message).click(function(){
		$(this).fadeOut(200);
		return false;
	});
	
//safe email address's
    $('span.safeemail').each(function(i) {
		var e = $(this).html();
		e = e.replace(" [at] ", "@");
		e = e.replace(" [dot] ", ".");
		$(this).html(e).replaceWith("<a href=\"mailto:" + $(this).text() + "\">" + $(this).text() + "</a>");
    });
	
//Set our isotope elements
	$('#choices').isotope({ filter: 'article',layoutMode : 'fitRows' });

//Filter the isotope elements
	$('#filters button').click(function(){
	var selector = $(this).attr('data-filter');
	$('#choices').isotope({ filter: selector });
	return false;
	});
	
//add class for selected filter buttons
	var filters = $('#filters');

	$(filters).find('button').click(function(){
		$(filters).find('button.selected').removeClass('selected');
		$(this).addClass('selected');
	});

});