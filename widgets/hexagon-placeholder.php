<?php
class Elementor_Hexagon_Placeholder_Widget extends \Elementor\Widget_Base {
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
    
        wp_register_style( 'hexagon-style', plugins_url( '/assets/hexagon-style.css', __FILE__ ) );
    }
    public function get_name() {
        return 'hexagon-placeholder';
    }

    public function get_title() {
        return __( 'Hexagon Placeholder', 'elementor-hexagon-placeholder' );
    }

    public function get_icon() {
        return 'fa fa-hexagon';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'plugin-name' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
    
        $repeater = new \Elementor\Repeater();
    
        $repeater->add_control(
            'image',
            [
                'label' => __( 'Background Image', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
    
        $repeater->add_control(
            'link',
            [
                'label' => __( 'Link', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'plugin-name' ),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );
    
        $repeater->add_control(
            'text',
            [
                'label' => __( 'Text', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __( 'Hexagon Text', 'plugin-name' ),
            ]
        );
        $repeater->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'transparent',
            ]
        );
    
        $repeater->add_control(
            'background_color',
            [
                'label' => __( 'Background Color', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );
    
        $repeater->add_control(
            'opacity',
            [
                'label' => __( 'Opacity', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => 0,
            ]
        );
    
        $repeater->add_control(
            'hover_text_color',
            [
                'label' => __( 'Hover Text Color', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );
    
        $repeater->add_control(
            'hover_background_color',
            [
                'label' => __( 'Hover Background Color', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );
    
        $repeater->add_control(
            'hover_opacity',
            [
                'label' => __( 'Hover Opacity', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
                'default' => 0.5,
            ]
        );
    
        $this->add_control(
            'hexagons',
            [
                'label' => __( 'Hexagons', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ text }}}',
            ]
        );
    
        $this->end_controls_section();
    }

    public function get_style_depends() {
        return [ 'hexagon-style' ];
    }
    
    protected function render() {
        wp_enqueue_style( 'hexagon-style' );

        ?>
        <ul id="zeroHexGrid">
            <?php
        $settings = $this->get_settings_for_display();
    
        foreach ($settings['hexagons'] as $index => $hexagon) {
            $target = $hexagon['link']['is_external'] ? ' target="_blank"' : '';
            $nofollow = $hexagon['link']['nofollow'] ? ' rel="nofollow"' : '';

            // Add a unique ID to each hexagon
            $id = 'hexagon-' . $index;  
        
            ?>
            <li id="<?php echo esc_attr( $id ); ?>" class="zeroHexLi">
                <div class="zeroHexDiv">
                    <a class="zeroHexLink" style="
                            --opacity: <?php echo esc_attr( $hexagon['opacity'] ); ?>;
                            --hover-opacity: <?php echo esc_attr( $hexagon['hover_opacity'] ); ?>;
                            --text-color: <?php echo esc_attr( $hexagon['text_color'] ); ?>;
                            --hover-text-color: <?php echo esc_attr( $hexagon['hover_text_color'] ); ?>;" href="<?php echo esc_url( $hexagon['link']['url'] ); ?>"<?php echo $target . $nofollow; ?>>
                        <div class='zeroHexImg' style="
                            --background-color: <?php echo esc_attr( $hexagon['background_color'] ); ?>;
                            --hover-background-color: <?php echo esc_attr( $hexagon['hover_background_color'] ); ?>;
                            background-image: url(<?php echo esc_url( $hexagon['image']['url'] ); ?>);">
                        </div>    
                        <?php echo wp_kses_post( $hexagon['text'] ); ?>
                    </a>
                </div>
            </li>
            <?php
        }?>
        
        </ul>
        <?php
    }

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Hexagon_Placeholder_Widget() );