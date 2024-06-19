<?php
class HexagonContainerWidget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'hexagon_container';
    }

    public function get_title() {
        return __( 'Hexagon Container', 'plugin-name' );
    }

    public function get_icon() {
        return 'fa fa-hexagon';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_style',
            [
                'label' => __( 'Style', 'plugin-name' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => __( 'Background Color', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hexagon-container' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $background_color = $settings['background_color'];
        ?>
        <div class="hexagon-container" style="background: <?php echo esc_attr( $background_color ); ?>;">
            <?php
            foreach ( $this->get_children() as $child_widget ) {
                $child_widget->render();
            }
            ?>
        </div>
        <?php
    }
}

add_action( 'elementor/widgets/widgets_registered', function( $widgets_manager ) {
    $widgets_manager->register_widget_type( new HexagonContainerWidget() );
} );