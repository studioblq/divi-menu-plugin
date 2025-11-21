<?php

class DiviMenuModule extends ET_Builder_Module {

    public function init() {
        $this->name = esc_html__('Custom Menu', 'et_builder');
        $this->slug = 'et_pb_custom_menu';
        $this->vb_support = 'on';
        $this->main_css_element = '.et_pb_custom_menu';
    }

    public function get_settings_modal_toggles() {
        return array(
            'general'  => array(
                'toggles' => array(
                    'menu_settings' => array(
                        'title'             => esc_html__('Impostazioni Menu', 'et_builder'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => array(
                            'menu'        => array('name' => esc_html__('Menu', 'et_builder')),
                            'orientation' => array('name' => esc_html__('Orientamento', 'et_builder')),
                        ),
                    ),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'menu_styling' => array(
                        'title'             => esc_html__('Stile Menu', 'et_builder'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => array(
                            'items'  => array('name' => esc_html__('Elementi', 'et_builder')),
                            'spacing' => array('name' => esc_html__('Spaziatura', 'et_builder')),
                        ),
                    ),
                ),
            ),
        );
    }

    public function get_fields() {
        $menus = wp_get_nav_menus();
        $menu_options = array();

        foreach ($menus as $menu) {
            $menu_options[$menu->term_id] = $menu->name;
        }

        return array(
            // Menu Selection
            'menu_id' => array(
                'label'           => esc_html__('Seleziona Menu', 'et_builder'),
                'type'            => 'select',
                'options'         => $menu_options,
                'default'         => '',
                'toggle_slug'     => 'menu_settings',
                'sub_toggle'      => 'menu',
                'description'     => esc_html__('Scegli il menu di WordPress da visualizzare', 'et_builder'),
            ),

            // Orientation
            'menu_orientation' => array(
                'label'           => esc_html__('Orientamento', 'et_builder'),
                'type'            => 'select',
                'options'         => array(
                    'horizontal' => esc_html__('Orizzontale', 'et_builder'),
                    'vertical'   => esc_html__('Verticale', 'et_builder'),
                ),
                'default'         => 'horizontal',
                'toggle_slug'     => 'menu_settings',
                'sub_toggle'      => 'orientation',
            ),

            // Menu Items Styling
            'menu_item_color' => array(
                'label'           => esc_html__('Colore Testo', 'et_builder'),
                'type'            => 'color',
                'default'         => '#333333',
                'toggle_slug'     => 'menu_styling',
                'sub_toggle'      => 'items',
            ),

            'menu_item_hover_color' => array(
                'label'           => esc_html__('Colore al Hover', 'et_builder'),
                'type'            => 'color',
                'default'         => '#0084ff',
                'toggle_slug'     => 'menu_styling',
                'sub_toggle'      => 'items',
            ),

            'menu_item_size' => array(
                'label'           => esc_html__('Dimensione Font', 'et_builder'),
                'type'            => 'range',
                'default'         => '16px',
                'range_settings'  => array(
                    'min'  => '10',
                    'max'  => '48',
                    'step' => '1',
                ),
                'toggle_slug'     => 'menu_styling',
                'sub_toggle'      => 'items',
                'unitType'        => 'length',
            ),

            // Spacing
            'menu_item_spacing' => array(
                'label'           => esc_html__('Spazio tra Elementi', 'et_builder'),
                'type'            => 'range',
                'default'         => '20px',
                'range_settings'  => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'toggle_slug'     => 'menu_styling',
                'sub_toggle'      => 'spacing',
                'unitType'        => 'length',
            ),

            'menu_item_padding' => array(
                'label'           => esc_html__('Padding Elementi', 'et_builder'),
                'type'            => 'range',
                'default'         => '10px',
                'range_settings'  => array(
                    'min'  => '0',
                    'max'  => '50',
                    'step' => '1',
                ),
                'toggle_slug'     => 'menu_styling',
                'sub_toggle'      => 'spacing',
                'unitType'        => 'length',
            ),
        );
    }

    public function render($attrs, $content, $render_slug) {
        $menu_id = $this->props['menu_id'];
        $orientation = $this->props['menu_orientation'];
        $item_color = $this->props['menu_item_color'];
        $hover_color = $this->props['menu_item_hover_color'];
        $item_size = $this->props['menu_item_size'];
        $item_spacing = $this->props['menu_item_spacing'];
        $item_padding = $this->props['menu_item_padding'];

        if (!$menu_id) {
            return '<p>' . esc_html__('Seleziona un menu', 'et_builder') . '</p>';
        }

        // Render custom CSS
        $this->generate_styles(
            array(
                'render_slug'      => $render_slug,
                'orientation'      => $orientation,
                'item_color'       => $item_color,
                'hover_color'      => $hover_color,
                'item_size'        => $item_size,
                'item_spacing'     => $item_spacing,
                'item_padding'     => $item_padding,
            )
        );

        $menu_class = 'et_pb_custom_menu ' . ($orientation === 'vertical' ? 'menu-vertical' : 'menu-horizontal');

        $args = array(
            'menu'            => (int) $menu_id,
            'container'       => 'div',
            'container_class' => $menu_class,
            'echo'            => false,
            'fallback_cb'     => false,
            'depth'           => 1,
            'link_before'     => '<span>',
            'link_after'      => '</span>',
        );

        $menu_html = wp_nav_menu($args);

        return $menu_html ?: '<p>' . esc_html__('Menu non trovato', 'et_builder') . '</p>';
    }

    private function generate_styles($args) {
        $render_slug = $args['render_slug'];
        $orientation = $args['orientation'];
        $item_color = $args['item_color'];
        $hover_color = $args['hover_color'];
        $item_size = $args['item_size'];
        $item_spacing = $args['item_spacing'];
        $item_padding = $args['item_padding'];

        $css_template = "
            .et_pb_custom_menu {
                display: flex;
                flex-direction: %s;
            }

            .et_pb_custom_menu ul {
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
                flex-direction: %s;
                gap: %s;
            }

            .et_pb_custom_menu li {
                margin: 0;
                padding: 0;
            }

            .et_pb_custom_menu a {
                color: %s;
                text-decoration: none;
                font-size: %s;
                padding: %s;
                display: inline-block;
                transition: color 0.3s ease;
            }

            .et_pb_custom_menu a:hover {
                color: %s;
            }

            .et_pb_custom_menu a span {
                display: inline;
            }
        ";

        $flex_direction = $orientation === 'vertical' ? 'column' : 'row';

        $css = sprintf(
            $css_template,
            $flex_direction,
            $flex_direction,
            $item_spacing,
            $item_color,
            $item_size,
            $item_padding,
            $hover_color
        );

        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => '.et_pb_custom_menu',
            'declaration' => $css,
        ));
    }
}

new DiviMenuModule();
