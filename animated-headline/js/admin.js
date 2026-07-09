/**
 * Animated Headline - Admin Settings Page JS
 * Version: 2.1.0
 */
(function($){

	function esc(str){
		return String(str || '').replace(/"/g, '&quot;');
	}

	function buildShortcode(){
		var sc = '[animated-headline';
		var fields = {
			title:         $('#ah-title').val(),
			animated_text: $('#ah-animated-text').val(),
			animation:     $('#ah-animation').val(),
			tag:           $('#ah-tag').val(),
			delay:         $('#ah-delay').val(),
			speed:         $('#ah-speed').val(),
		};
		$.each(fields, function(key, val){
			if(val){ sc += ' ' + key + '="' + esc(val) + '"'; }
		});
		sc += ']';
		return sc;
	}

	function buildPreview(){
		var title     = $('<span/>').text($('#ah-title').val()).html() || '&nbsp;';
		var rawWords  = String($('#ah-animated-text').val() || '');
		var words     = rawWords.split(',').map(function(w){ return $.trim(w); }).filter(Boolean);
		var animation = $('#ah-animation').val() || 'rotate-1';
		var tag       = $('#ah-tag').val() || 'h1';
		var delay     = $('#ah-delay').val();
		var speed     = $('#ah-speed').val();

		if(!words.length) words = ['...'];

		var cls = 'cd-headline ' + animation;
		if(['rotate-2','rotate-3','type','scale'].indexOf(animation) !== -1){
			cls += ' letters';
		}

		var dataAttrs = '';
		if(delay){ dataAttrs += ' data-delay="' + parseInt(delay) + '"'; }
		if(speed){ dataAttrs += ' data-speed="' + parseInt(speed) + '"'; }

		var html = '<' + tag + ' class="' + cls + '"' + dataAttrs + '>';
		html += '<span> ' + title + ' </span> ';
		html += '<span class="cd-words-wrapper">';
		$.each(words, function(i, word){
			html += '<b class="' + (i === 0 ? 'is-visible' : '') + '">';
			html += $('<span/>').text(word).html();
			html += '</b>\n';
		});
		html += '</span></' + tag + '>';

		$('#ah-preview-box').html(html);

		// Re-initialise the animation in the preview
		if(typeof window.AnimatedHeadlineInit === 'function'){
			var $el = $('#ah-preview-box .cd-headline');
			$el.removeData();
			window.AnimatedHeadlineInit($el);
		}
	}

	function refresh(){
		$('#ah-shortcode-output').val(buildShortcode());
		buildPreview();
	}

	$(function(){
		// Trigger refresh on any input change
		$(document).on('input change', '#ah-title,#ah-animated-text,#ah-animation,#ah-tag,#ah-delay,#ah-speed', function(){
			refresh();
		});

		// Copy shortcode
		$('#ah-copy-btn').on('click', function(){
			var $inp = $('#ah-shortcode-output');
			$inp[0].select();
			document.execCommand('copy');
			var $btn = $(this);
			$btn.text('Copied!');
			setTimeout(function(){ $btn.text('Copy Shortcode'); }, 2000);
		});

		// Initial build
		refresh();
	});

})(jQuery);
