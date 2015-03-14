<?php

class WYSIWYG_Widgets_Admin
{

	public function __construct()
	{
		//add_action('init', array($this, 'add_caps') );
		add_action( 'add_meta_boxes', array($this, 'add_meta_box'), 20 );
	}

	public function add_caps() {
		$caps_version = '1.1';

		// did we add the caps already?
		if( version_compare(get_option('wywi_caps_version', 0), $caps_version, '>=') ) {
			return;
		}
		
		$role = get_role('administrator');
		$role->add_cap('edit_widget_block');
		//update_option('wywi_caps_version', $caps_version);
	}

	public function add_meta_box()
	{
		add_meta_box( 
        'wysiwyg-widget-donate-box',
	        __('More..', 'wysiwyg-widgets'),
	        array($this, 'meta_donate_box'),
	        'wysiwyg-widget',
	        'side',
            'low'
	    );
	}

	public function register_widget()
	{
		register_widget('WYSIWYG_Widgets_Widget');  
	}

	public function meta_donate_box($post)
	{
		?>
			<div>
				<h4><?php _e('And now?', 'wysiwyg-widgets'); ?></h4>
				<p><?php printf(__('Show this widget block by going to your %swidgets page%s and then dragging the WYSIWYG Widget to one of your widget areas.', 'wysiwyg-widgets'), '<a href="'. admin_url('widgets.php') .'">', '</a>'); ?></p>
			</div>

			<div>
				<h4>Donate $10, $20 or $50</h4>
				<p>I spent a lot of time developing this plugin and offering support for it. If you like it, consider supporting this plugin by <a href="http://dannyvankooten.com/donate/">donating a token of your appreciation</a>.</p>
			
				<p>Some other ways to support this plugin</p>
				<ul class="ul-square">
					<li><a href="http://wordpress.org/support/view/plugin-reviews/wysiwyg-widgets?rate=5#postform" target="_blank"><?php _e('Leave a &#9733;&#9733;&#9733;&#9733;&#9733; review on WordPress.org', 'wysiwyg-widgets'); ?></a></li>
                	<li><a href="http://twitter.com/?status=I%20use%20the%20WYSIWYG%20Widgets%20plugin%20by%20%40DannyvanKooten%20on%20my%20%23WordPress%20site%20to%20show%20beautiful%20widgets%20-%20love%20it!%20http%3A%2F%2Fwordpress.org%2Fplugins%2Fwysiwyg-widgets%2F" target="_blank"><?php _e('Tweet about WYSIWYG Widgets', 'wysiwyg-widgets'); ?></a></li>
            		<li><a href="http://wordpress.org/plugins/wysiwyg-widgets/#compatibility"><?php _e('Vote "works" on the WordPress.org plugin page', 'wysiwyg-widgets'); ?></a></li>
				</ul>
			</div>

			<div>
				<h4><?php _e('Other useful plugins', 'wysiwyg-widgets'); ?></h4>
				<ul class="ul-square">
					<li><a href="http://wordpress.org/plugins/mailchimp-for-wp/">MailChimp for Wordpress</a></li>
					<li><a href="http://wordpress.org/plugins/recent-facebook-posts/">Recent Facebook Posts</a></li>
					<li><a href="http://wordpress.org/plugins/scroll-triggered-boxes/">Scroll Triggered Boxes</a></li>
				</ul>
			</div>

			<div>
				<h4>About the developer</h4>
				<p>My name is <a href="http://dannyvankooten.com/">Danny van Kooten</a>. I develop WordPress plugins which help you build your websites. I love simplicity, happy customers and clean code.</p>
				<p>Take a look at my other <a href="http://dannyvankooten.com/wordpress-plugins/">plugins for WordPress</a> or <em>like</em> my Facebook page to stay updated.</p>
				<p><iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2FCodeToTheChase&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=true&amp;share=false&amp;appId=225994527565061" scrolling="no" frameborder="0" style="border:none; width: 100%; overflow:hidden; height: 80px;" allowTransparency="true"></iframe></p>
				<p>You can also follow me on twitter <a href="http://twitter.com/dannyvankooten">here</a>.</p>
			</div>

		<?php
	}
}