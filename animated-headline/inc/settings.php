<div class="wrap ah-admin-wrap">
	<h1><?php esc_html_e('Animated Headline', 'animated-headline'); ?></h1>

	<div class="ah-layout">

		<!-- LEFT: Shortcode Generator -->
		<div class="ah-left-col">
			<div class="ah-card">
				<h2><?php esc_html_e('Shortcode Generator', 'animated-headline'); ?></h2>

				<div class="ah-field-grid">
					<label>
						<?php esc_html_e('Title text', 'animated-headline'); ?>
						<input type="text" id="ah-title" value="Hello my friend" placeholder="Hello my friend">
					</label>

					<label>
						<?php esc_html_e('Animated words', 'animated-headline'); ?>
						<input type="text" id="ah-animated-text" value="Awesome,Amazing,Cool" placeholder="word1,word2,word3">
					</label>

					<label>
						<?php esc_html_e('Animation style', 'animated-headline'); ?>
						<select id="ah-animation">
							<?php foreach($animations as $value => $label) : ?>
								<option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
							<?php endforeach; ?>
						</select>
					</label>

					<label>
						<?php esc_html_e('HTML tag', 'animated-headline'); ?>
						<select id="ah-tag">
							<?php foreach(array('h1','h2','h3','h4','h5','h6','div') as $t) : ?>
								<option value="<?php echo esc_attr($t); ?>"><?php echo esc_html(strtoupper($t)); ?></option>
							<?php endforeach; ?>
						</select>
					</label>

					<label>
						<?php esc_html_e('Delay (ms)', 'animated-headline'); ?>
						<input type="number" id="ah-delay" min="500" max="10000" step="100" value="2500">
					</label>

					<label>
						<?php esc_html_e('Speed (ms)', 'animated-headline'); ?>
						<input type="number" id="ah-speed" min="100" max="3000" step="50" value="600">
					</label>
				</div>

				<div class="ah-shortcode-row">
					<input type="text" id="ah-shortcode-output" readonly placeholder="Your shortcode will appear here...">
					<button type="button" class="button button-primary" id="ah-copy-btn">
						<?php esc_html_e('Copy Shortcode', 'animated-headline'); ?>
					</button>
				</div>
			</div>

			<!-- How to Use -->
			<div class="ah-card">
				<h2><?php esc_html_e('How to Use', 'animated-headline'); ?></h2>
				<p><?php esc_html_e('Use the generator above to create a shortcode, then paste it into any post or page.', 'animated-headline'); ?></p>
				<p>
					<strong><?php esc_html_e('Optional parameters:', 'animated-headline'); ?></strong><br>
					<code>tag="h2"</code> &mdash; <?php esc_html_e('HTML tag to use (h1&ndash;h6, div)', 'animated-headline'); ?><br>
					<code>delay="2500"</code> &mdash; <?php esc_html_e('Milliseconds between word changes', 'animated-headline'); ?><br>
					<code>speed="600"</code> &mdash; <?php esc_html_e('Animation transition speed in ms', 'animated-headline'); ?>
				</p>
			</div>
		</div>

		<!-- RIGHT: Preview + Donate -->
		<div class="ah-right-col">
			<div class="ah-card">
				<h2><?php esc_html_e('Live Preview', 'animated-headline'); ?></h2>
				<div class="ah-preview-box" id="ah-preview-box"></div>
			</div>

			<div class="ah-card ah-donate-card">
				<h2><?php esc_html_e('Support This Plugin', 'animated-headline'); ?></h2>
				<p><?php esc_html_e('If this plugin saves you time, please consider a small donation to keep it maintained and updated.', 'animated-headline'); ?></p>
				<a href="https://www.paypal.me/anshulgangrade" target="_blank" class="ah-donate-btn">
					<span class="dashicons dashicons-heart"></span>
					<?php esc_html_e('Donate via PayPal', 'animated-headline'); ?>
				</a>
			</div>
		</div>

	</div><!-- .ah-layout -->

	<!-- Available Animations -->
	<div class="ah-card ah-bottom-section">
		<h2><?php printf(esc_html__('Available Animations (%d)', 'animated-headline'), count($animations)); ?></h2>
		<ul class="ah-anim-list">
			<?php foreach($animations as $value => $label) : ?>
				<li><code><?php echo esc_html($value); ?></code> &mdash; <?php echo esc_html($label); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>

</div><!-- .ah-admin-wrap -->
