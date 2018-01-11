<?php

	/**
	 * Textbox Control
	 *
	 * Main options:
	 *  name            => a name of the control
	 *  value           => a value to show in the control
	 *  default         => a default value of the control if the "value" option is not specified
	 *  maxLength       => set the max length of text in the input control
	 *  placeholder     => a placeholder text for the control when the control value is empty
	 *
	 *  Использование datepicker в текстовом поле (необходимо подключить bootstrap.datepicker)
	 * 'htmlAttrs' => array(
	 * 'data-provide' => 'datepicker-inline',
	 * 'data-date-language' => 'ru',
	 * 'data-date-autoclose' => 'true'
	 * )
	 *
	 * @author Paul Kashtanoff <paul@byonepress.com>
	 * @copyright (c) 2013, OnePress Ltd
	 *
	 * @package factory-forms
	 * @since 1.0.0
	 */
	class FactoryForms000_TextboxControl extends FactoryForms000_Control {

		public $type = 'textbox';

		/**
		 * Preparing html attributes before rendering html of the control.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		protected function beforeHtml()
		{
			$value = esc_attr($this->getValue());
			$nameOnForm = $this->getNameOnForm();

			if( $this->getOption('maxLength', false) ) {
				$this->addHtmlAttr('maxlength', intval($this->getOption('maxLength')));
			}

			if( $this->getOption('placeholder', false) ) {
				$this->addHtmlAttr('placeholder', $this->getOption('placeholder'));
			}

			$this->addCssClass('form-control');
			$this->addHtmlAttr('type', 'text');
			$this->addHtmlAttr('id', $nameOnForm);
			$this->addHtmlAttr('name', $nameOnForm);
			$this->addHtmlAttr('value', $value);
		}

		/**
		 * Shows the html markup of the control.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function html()
		{
			$units = $this->getOption('units', false);
			?>
			<?php if( $units ) { ?><div class="input-group"><?php } ?>
			<input <?php $this->attrs() ?>/>
			<?php if( $units ) { ?>
			<span class="input-group-addon"><?php echo $units; ?></span>
		<?php } ?>
			<?php if( $units ) { ?></div><?php } ?>
		<?php
		}

		public function getSubmitValue($name, $subName)
		{
			$nameOnForm = $this->getNameOnForm($name);

			return isset($_POST[$nameOnForm])
				? sanitize_text_field($_POST[$nameOnForm])
				: '';
		}
	}
