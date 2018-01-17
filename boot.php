<?php
	/**
	 * Factory Forms
	 *
	 * Factory Forms is a Factory module that provides a declarative
	 * way to build forms without any extra html or css markup.
	 *
	 * @author Paul Kashtanoff <paul@byonepress.com>, Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 2013, OnePress Ltd, (c) 2017 Webcraftic Ltd
	 *
	 * @package factory-forms
	 * @since 1.0.1
	 */

	// the module provides function for the admin area only

	if( !is_admin() ) {
		return;
	}

	// checks if the module is already loaded in order to
	// prevent loading the same version of the module twice.
	if( defined('FACTORY_FORMS_000_LOADED') ) {
		return;
	}

	define('FACTORY_FORMS_000_LOADED', true);

	// absolute path and URL to the files and resources of the module.
	define('FACTORY_FORMS_000_DIR', dirname(__FILE__));
	define('FACTORY_FORMS_000_URL', plugins_url(null, __FILE__));

	#comp merge
	require(FACTORY_FORMS_000_DIR . '/includes/providers/value-provider.interface.php');
	require(FACTORY_FORMS_000_DIR . '/includes/providers/meta-value-provider.class.php');
	require(FACTORY_FORMS_000_DIR . '/includes/providers/options-value-provider.class.php');

	require(FACTORY_FORMS_000_DIR . '/includes/form.class.php');
	require(FACTORY_FORMS_000_DIR . '/helpers.php');
	#endcomp

	load_plugin_textdomain('factory_forms_000', false, dirname(plugin_basename(__FILE__)) . '/langs');

	/**
	 * We add this code into the hook because all these controls quite heavy. So in order to get better perfomance,
	 * we load the form controls only on pages where the forms are created.
	 *
	 * @see the 'factory_forms_000_register_controls' hook
	 *
	 * @since 3.0.7
	 */
	if( !function_exists('factory_forms_000_register_default_controls') ) {

		function factory_forms_000_register_default_controls($plugin)
		{

			if( $plugin && !isset($plugin->forms) ) {
				throw new Exception("The module Factory Forms is not loaded for the plugin '{$plugin->pluginName}'.");
			}

			require_once(FACTORY_FORMS_000_DIR . '/includes/html-builder.class.php');
			require_once(FACTORY_FORMS_000_DIR . '/includes/form-element.class.php');
			require_once(FACTORY_FORMS_000_DIR . '/includes/control.class.php');
			require_once(FACTORY_FORMS_000_DIR . '/includes/complex-control.class.php');
			require_once(FACTORY_FORMS_000_DIR . '/includes/holder.class.php');
			require_once(FACTORY_FORMS_000_DIR . '/includes/control-holder.class.php');
			require_once(FACTORY_FORMS_000_DIR . '/includes/custom-element.class.php');
			require_once(FACTORY_FORMS_000_DIR . '/includes/form-layout.class.php');

			// registration of controls
			$plugin->forms->registerControls(array(
				array(
					'type' => 'checkbox',
					'class' => 'FactoryForms000_CheckboxControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/checkbox.php'
				),
				array(
					'type' => 'list',
					'class' => 'FactoryForms000_ListControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/list.php'
				),
				array(
					'type' => 'dropdown',
					'class' => 'FactoryForms000_DropdownControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/dropdown.php'
				),
				array(
					'type' => 'dropdown-and-colors',
					'class' => 'FactoryForms000_DropdownAndColorsControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/dropdown-and-colors.php'
				),
				array(
					'type' => 'hidden',
					'class' => 'FactoryForms000_HiddenControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/hidden.php'
				),
				array(
					'type' => 'hidden',
					'class' => 'FactoryForms000_HiddenControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/hidden.php'
				),
				array(
					'type' => 'radio',
					'class' => 'FactoryForms000_RadioControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/radio.php'
				),
				array(
					'type' => 'radio-colors',
					'class' => 'FactoryForms000_RadioColorsControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/radio-colors.php'
				),
				array(
					'type' => 'textarea',
					'class' => 'FactoryForms000_TextareaControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/textarea.php'
				),
				array(
					'type' => 'textbox',
					'class' => 'FactoryForms000_TextboxControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/textbox.php'
				),
				array(
					'type' => 'multiple-textbox',
					'class' => 'FactoryForms000_MultipleTextboxControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/multiple-textbox.php'
				),
				array(
					'type' => 'datetimepicker-range',
					'class' => 'FactoryForms000_DatepickerRangeControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/datepicker-range.php'
				),
				array(
					'type' => 'url',
					'class' => 'FactoryForms000_UrlControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/url.php'
				),
				array(
					'type' => 'wp-editor',
					'class' => 'FactoryForms000_WpEditorControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/wp-editor.php'
				),
				array(
					'type' => 'color',
					'class' => 'FactoryForms000_ColorControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/color.php'
				),
				array(
					'type' => 'color-and-opacity',
					'class' => 'FactoryForms000_ColorAndOpacityControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/color-and-opacity.php'
				),
				array(
					'type' => 'gradient',
					'class' => 'FactoryForms000_GradientControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/gradient.php'
				),
				array(
					'type' => 'font',
					'class' => 'FactoryForms000_FontControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/font.php'
				),
				array(
					'type' => 'google-font',
					'class' => 'FactoryForms000_GoogleFontControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/google-font.php'
				),
				array(
					'type' => 'pattern',
					'class' => 'FactoryForms000_PatternControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/pattern.php'
				),
				array(
					'type' => 'integer',
					'class' => 'FactoryForms000_IntegerControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/integer.php'
				),
				array(
					'type' => 'control-group',
					'class' => 'FactoryForms000_ControlGroupHolder',
					'include' => FACTORY_FORMS_000_DIR . '/controls/holders/control-group.php'
				),
				array(
					'type' => 'paddings-editor',
					'class' => 'FactoryForms000_PaddingsEditorControl',
					'include' => FACTORY_FORMS_000_DIR . '/controls/paddings-editor.php'
				),
			));

			// registration of control holders
			$plugin->forms->registerHolders(array(
				array(
					'type' => 'tab',
					'class' => 'FactoryForms000_TabHolder',
					'include' => FACTORY_FORMS_000_DIR . '/controls/holders/tab.php'
				),
				array(
					'type' => 'tab-item',
					'class' => 'FactoryForms000_TabItemHolder',
					'include' => FACTORY_FORMS_000_DIR . '/controls/holders/tab-item.php'
				),
				array(
					'type' => 'accordion',
					'class' => 'FactoryForms000_AccordionHolder',
					'include' => FACTORY_FORMS_000_DIR . '/controls/holders/accordion.php'
				),
				array(
					'type' => 'accordion-item',
					'class' => 'FactoryForms000_AccordionItemHolder',
					'include' => FACTORY_FORMS_000_DIR . '/controls/holders/accordion-item.php'
				),
				array(
					'type' => 'control-group',
					'class' => 'FactoryForms000_ControlGroupHolder',
					'include' => FACTORY_FORMS_000_DIR . '/controls/holders/control-group.php'
				),
				array(
					'type' => 'control-group-item',
					'class' => 'FactoryForms000_ControlGroupItem',
					'include' => FACTORY_FORMS_000_DIR . '/controls/holders/control-group-item.php'
				),
				array(
					'type' => 'form-group',
					'class' => 'FactoryForms000_FormGroupHolder',
					'include' => FACTORY_FORMS_000_DIR . '/controls/holders/form-group.php'
				),
				array(
					'type' => 'more-link',
					'class' => 'FactoryForms000_MoreLinkHolder',
					'include' => FACTORY_FORMS_000_DIR . '/controls/holders/more-link.php'
				),
				array(
					'type' => 'div',
					'class' => 'FactoryForms000_DivHolder',
					'include' => FACTORY_FORMS_000_DIR . '/controls/holders/div.php'
				),
				array(
					'type' => 'columns',
					'class' => 'FactoryForms000_ColumnsHolder',
					'include' => FACTORY_FORMS_000_DIR . '/controls/holders/columns.php'
				)
			));

			// registration custom form elements
			$plugin->forms->registerCustomElements(array(
				array(
					'type' => 'html',
					'class' => 'FactoryForms000_Html',
					'include' => FACTORY_FORMS_000_DIR . '/controls/customs/html.php',
				),
				array(
					'type' => 'separator',
					'class' => 'FactoryForms000_Separator',
					'include' => FACTORY_FORMS_000_DIR . '/controls/customs/separator.php',
				),
			));

			// registration of form layouts
			$plugin->forms->registerFormLayout(array(
				'name' => 'bootstrap-2',
				'class' => 'FactoryForms000_Bootstrap2FormLayout',
				'include' => FACTORY_FORMS_000_DIR . '/layouts/bootstrap-2/bootstrap-2.php'
			));
			$plugin->forms->registerFormLayout(array(
				'name' => 'bootstrap-3',
				'class' => 'FactoryForms000_Bootstrap3FormLayout',
				'include' => FACTORY_FORMS_000_DIR . '/layouts/bootstrap-3/bootstrap-3.php'
			));
		}

		add_action('factory_forms_000_register_controls', 'factory_forms_000_register_default_controls');
	}