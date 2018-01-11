<?php

	/**
	 * Radio Colors Control
	 *
	 * Main options:
	 *  name       => a name of the control
	 *  value      => a value to show in the control
	 *  default    => a default value of the control if the "value" option is not specified
	 *  data       => a callback to return items or an array of items to select
	 * 'data' => array(
	 *      array('default', '#75649b'),
	 *      array('black', '#222'),
	 *      array('light', '#fff3ce'),
	 *      array('forest', '#c9d4be'),
	 *)
	 *
	 * @author Alex Kovalevv <alex.kovalevv@gmail.com>
	 * @copyright (c) 2017, OnePress Ltd
	 *
	 * @package factory-forms
	 * @since 1.0.0
	 */
	class FactoryForms000_RadioColorsControl extends FactoryForms000_Control {

		public $type = 'radio-color';

		/**
		 * Returns a set of available items for the radio.
		 *
		 * @since 1.0.0
		 * @return mixed[]
		 */
		private function getItems()
		{
			$data = $this->getOption('data', array());

			// if the data options is a valid callback for an object method
			if( is_array($data) && count($data) == 2 && gettype($data[0]) == 'object' ) {

				return call_user_func($data);
				// if the data options is a valid callback for a function
			} elseif( gettype($data) == 'string' ) {

				return $data();
			}

			// if the data options is an array of values
			return $data;
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
			$this->addHtmlAttr('name', $nameOnForm);

			echo '<div class="factory-colors-inner-wrap" data-radio-name="' . $nameOnForm . '">';
		}

		/**
		 * Preparing html attributes afterHtml rendering html of the control.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		protected function afterHtml()
		{
			echo '</div>';
		}

		/**
		 * Shows the html markup of the control.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function html()
		{
			$items = $this->getItems();
			$value = $this->getValue();

			?>
			<?php foreach($items as $item) {
			$checked = ($item[0] == $value)
				? 'checked="checked"'
				: '';

			if( empty($item[1]) || strpos($item[1], '#') === false ) {
				$item[1] = '#fff';
			}
			?>
			<span class="factory-form-radio-item">
                <label class="factory-from-radio-label">
	                <input type="radio" <?php $this->attrs() ?> value="<?php echo esc_attr($item[0]) ?>" <?php echo $checked ?>/>
	                <span style="background-color:<?= esc_attr($item[1]) ?>"></span>
	                </lable>
            </span>
		<?php }
		}
	}
