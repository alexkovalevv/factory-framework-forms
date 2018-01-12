<?php

	/**
	 * Textarea Control
	 *
	 * Main options:
	 *  name            => a name of the control
	 *  value           => a value to show in the control
	 *  default         => a default value of the control if the "value" option is not specified
	 *
	 * @author Paul Kashtanoff <paul@byonepress.com>
	 * @copyright (c) 2013, OnePress Ltd
	 *
	 * @package factory-forms
	 * @since 1.0.0
	 */
	class FactoryForms000_TextareaControl extends FactoryForms000_Control {

		public $type = 'textarea';

		/**
		 * Returns a submit value of the control by a given name.
		 *
		 * @since 1.0.0
		 * @return mixed
		 */
		public function getSubmitValue($name, $subName)
		{
			$nameOnForm = $this->getNameOnForm($name);
			$value = isset($_POST[$nameOnForm])
				? $_POST[$nameOnForm]
				: null;
			if( is_array($value) ) {
				$value = implode(',', $value);
			}

			return sanitize_textarea_field($value);
		}

		/**
		 * Preparing html attributes before rendering html of the control.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		protected function beforeHtml()
		{
			$nameOnForm = $this->getNameOnForm();
			$height = (int)$this->getOption('height', 100);

			$this->addCssClass('form-control');
			$this->addHtmlAttr('name', $nameOnForm);
			$this->addHtmlAttr('id', $nameOnForm);
			$this->addHtmlAttr('style', 'min-height:' . $height . 'px');
		}

		/**
		 * Shows the html markup of the control.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function html()
		{
			?>
                <textarea <?php $this->attrs(); ?> /><?php echo esc_textarea($this->getValue()); ?></textarea>
            <?php
		}
	}
