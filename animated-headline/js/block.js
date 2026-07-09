/**
 * Animated Headline - Gutenberg Block
 * Version: 2.1.0
 * Editor uses static preview (no REST API call = no JSON errors)
 * Frontend rendering is handled by PHP render_callback
 */
(function(blocks, element, components, blockEditor, i18n){
	var el               = element.createElement;
	var __               = i18n.__;
	var Fragment         = element.Fragment;
	var InspectorControls = blockEditor.InspectorControls;
	var PanelBody        = components.PanelBody;
	var TextControl      = components.TextControl;
	var SelectControl    = components.SelectControl;
	var RangeControl     = components.RangeControl;

	// Build animation dropdown from localized PHP data
	var animOpts = Object.keys(AnimatedHeadlineBlock.animations || {}).map(function(key){
		return { label: AnimatedHeadlineBlock.animations[key], value: key };
	});

	var tagOpts = ['h1','h2','h3','h4','h5','h6','div'].map(function(t){
		return { label: t.toUpperCase(), value: t };
	});

	blocks.registerBlockType('animated-headline/headline', {
		title:       __('Animated Headline', 'animated-headline'),
		description: __('Display a headline with rotating animated words.', 'animated-headline'),
		icon:        'editor-textcolor',
		category:    'design',
		keywords:    [__('animated', 'animated-headline'), __('headline', 'animated-headline'), __('text', 'animated-headline')],

		attributes: {
			title:         { type: 'string', default: 'Hello my friend' },
			animated_text: { type: 'string', default: 'Awesome,Amazing,Wonderful' },
			animation:     { type: 'string', default: 'rotate-1' },
			tag:           { type: 'string', default: 'h1' },
			delay:         { type: 'string', default: '' },
			speed:         { type: 'string', default: '' },
		},

		edit: function(props){
			var a = props.attributes;

			// Helper: update a single attribute
			function set(key){
				return function(val){
					var obj = {};
					obj[key] = (val === undefined || val === null) ? '' : String(val);
					props.setAttributes(obj);
				};
			}

			// Build a static editor preview (no REST API = no JSON errors)
			var words    = (a.animated_text || 'World').split(',').map(function(w){ return w.trim(); }).filter(Boolean);
			var wordList = words.join(' / ');

			var previewBox = el('div', {
					style: {
						background:    '#f6f7f7',
						border:        '2px dashed #c3c4c7',
						borderRadius:  '4px',
						padding:       '24px 20px',
						textAlign:     'center',
						minHeight:     '80px',
					}
				},
				el('p', {
					style: { margin: '0 0 8px', fontSize: '12px', color: '#8c8f94', textTransform: 'uppercase', letterSpacing: '0.5px' }
				}, '✦ Animated Headline — ' + a.animation),

				el('div', {
					style: { fontSize: '22px', fontWeight: '700', lineHeight: '1.3', color: '#1d2327' }
				},
					el('span', {}, a.title + ' '),
					el('span', { style: { color: '#e06c00', fontStyle: 'italic' } }, words[0] || '…')
				),

				el('p', {
					style: { margin: '10px 0 0', fontSize: '12px', color: '#8c8f94' }
				}, '↻ ' + wordList)
			);

			return el(Fragment, {},
				// Sidebar controls
				el(InspectorControls, {},
					el(PanelBody, { title: __('Content', 'animated-headline'), initialOpen: true },
						el(TextControl, {
							label:    __('Title text', 'animated-headline'),
							help:     __('The static part before the animated word', 'animated-headline'),
							value:    a.title,
							onChange: set('title'),
						}),
						el(TextControl, {
							label:    __('Animated words', 'animated-headline'),
							help:     __('Comma separated e.g. Awesome,Amazing,Cool', 'animated-headline'),
							value:    a.animated_text,
							onChange: set('animated_text'),
						}),
						el(SelectControl, {
							label:    __('Animation style', 'animated-headline'),
							value:    a.animation,
							options:  animOpts,
							onChange: set('animation'),
						}),
						el(SelectControl, {
							label:    __('HTML tag', 'animated-headline'),
							value:    a.tag,
							options:  tagOpts,
							onChange: set('tag'),
						})
					),
					el(PanelBody, { title: __('Timing', 'animated-headline'), initialOpen: false },
						el(RangeControl, {
							label:    __('Delay (ms)', 'animated-headline'),
							help:     __('Time between word changes', 'animated-headline'),
							value:    parseInt(a.delay) || 2500,
							min:      500,
							max:      8000,
							step:     100,
							onChange: set('delay'),
						}),
						el(RangeControl, {
							label:    __('Speed (ms)', 'animated-headline'),
							help:     __('Animation speed', 'animated-headline'),
							value:    parseInt(a.speed) || 600,
							min:      100,
							max:      3000,
							step:     50,
							onChange: set('speed'),
						})
					)
				),

				// Block canvas preview
				previewBox
			);
		},

		// Frontend output handled by PHP render_callback
		save: function(){ return null; },
	});

})(window.wp.blocks, window.wp.element, window.wp.components, window.wp.blockEditor, window.wp.i18n);
