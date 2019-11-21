<?php
/**
 * GoDaddy Reseller Store Domain Widget tests
 */

namespace Reseller_Store;

final class TestWidgetDomainSimple extends TestCase {

	/**
	 * @testdox Test Cart widgets exist.
	 */
	function test_basics() {

		$this->assertTrue(
			class_exists( __NAMESPACE__ . '\Widgets\Domain_Simple' ),
			'Class \Widgets\Domain_Simple is not found'
		);

	}

	/**
	 * @testdox Given a valid instance the widget should render
	 */
	function test_widget() {

		$widget = new Widgets\Domain_Simple();

		rstore_update_option( 'pl_id', 12345 );

		$instance = array(
			'title'            => 'title',
			'text_placeholder' => 'find your domain',
		);

		$args = array(
			'before_widget' => '<div class="before_widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		);

		$this->assertRegExp(
			'/<form role="search" method="get" class="search-form" action="https:\/\/www.secureserver.net\/products\/domain-registration\/find\/\?plid=12345">/',
			$widget->widget( $args, $instance )
		);

	}

	/**
	 * @testdox Given a new instance the instance should update
	 */
	function test_widget_update() {

		$widget = new Widgets\Domain_Simple();

		$old_instance = array(
			'title'            => '',
			'text_placeholder' => '',
			'text_search'      => '',
		);

		$new_instance = array(
			'title'            => 'title 1',
			'text_placeholder' => 'placeholder',
			'text_search'      => 'text_search',
		);

		$instance = $widget->update( $new_instance, $old_instance );

		foreach ( $instance as $key => $value ) {
			$this->assertEquals( $instance[ $key ], $new_instance[ $key ] );
		}

	}

	/**
	 * @testdox Given an instance the form should render
	 */
	function test_widget_form() {

		$widget = new Widgets\Domain_Simple();

		$instance = array(
			'title'            => 'aaa',
			'text_placeholder' => 'bbb',
			'text_search'      => 'ccc',
		);

		$widget->form( $instance );

		foreach ( $instance as $key => $value ) {
			$this->expectOutputRegex( '/<input type="text" id="widget-rstore_domain_simple--title" name="widget-rstore_domain_simple\[\]\[title\]" value="aaa" class="widefat">/' );
		}

	}

	/**
	 * @testdox Given an a domain search widget classes filter it should render
	 */
	function test_widget_filter() {

		add_filter(
			'rstore_domain_widget_classes',
			function( $title ) {
				return array( 'domain' );
			}
		);

		$widget = new Widgets\Domain_Simple();

		rstore_update_option( 'pl_id', 12345 );

		$instance = array(
			'image_size' => 'full',
			'show_title' => true,
		);

		$args = array(
			'before_widget' => '<div class="before_widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		);

		$this->assertRegExp(
			'/<div class="before_widget domain">/',
			$widget->widget( $args, $instance )
		);

	}


}
