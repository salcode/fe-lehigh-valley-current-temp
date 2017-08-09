<?php
/**
 * Lehigh Valley Current Temp Widget
 *
 * This WordPress widget provides the current temperature for a
 * Lehigh Valley.  This class has a dependency on the function
 * fe_get_lv_temp_f()
 * which returns the temperature in degrees F as a string.
 */
class Fe_Lehigh_Valley_Current_Temp_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$args = array(
			'classname' => 'fe-lehigh-valley-current-temp',
			'description' => esc_html__( 'Display the current temperature for Lehigh Valley', 'fe-lehigh-valley-current-temp' ),
		);
		parent::__construct(
			'fe-lehigh-valley-current-temp',
			esc_html__( 'Lehigh Valley Current Temp', 'fe-lehigh-valley-current-temp' ),
			$args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		$temperature = fe_get_lv_temp_f();

		echo $args['before_widget'];

			echo $args['before_title'],
				'<a href="https://2017.lehighvalley.wordcamp.org">',
				esc_html__( 'WordCamp Lehigh Valley', 'fe-lehigh-valley-current-temp' ),
				'</a>',
			$args['after_title'];

			echo '<p class="fe-gswt-demo-temp-info">';
				printf(
					esc_html__( 'Outdoor temperature is %s&deg; F', 'fe-lehigh-valley-current-temp' ),
					esc_html( $temperature )
				);
			echo '</p><!-- fe-gswt-demo-temp-info -->';

			printf(
				'<a class="fe-gswt-demo-dark-sky-credits" href="https://darksky.net/poweredby/">%s</a>',
				esc_html__( 'Powered by DarkSky', 'fe-lehigh-valley-current-temp' )
			);

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		?>
		<p>This widget has no modifiable fields. The Dark Sky API key must be added as a constant called <code>FE_DARK_SKY_API</code> in <strong>wp-config.php</strong>. If you don't have one, apply for a <a href="https://darksky.net/dev/">Dark Sky API key</a></p>
		<?php
	}

} // class Fe_Dark_Sky_Transient_Demo_Widget
