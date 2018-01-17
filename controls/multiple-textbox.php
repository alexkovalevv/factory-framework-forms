<?php

	/**
	 * Control multiple textbox
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 22.11.2017, Webcraftic
	 *
	 * @package factory-forms
	 * @since 1.0.0
	 */
	class FactoryForms000_MultipleTextboxControl extends FactoryForms000_Control {

		public $type = 'multiple-textbox';

		/**
		 * Preparing html attributes before rendering html of the control.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		protected function beforeHtml()
		{

			$nameOnForm = $this->getNameOnForm();

			if( $this->getOption('maxLength', false) ) {
				$this->addHtmlAttr('maxlength', intval($this->getOption('maxLength')));
			}

			if( $this->getOption('placeholder', false) ) {
				$this->addHtmlAttr('placeholder', $this->getOption('placeholder'));
			}

			$this->addCssClass('form-control');
			$this->addHtmlAttr('type', 'text');
			//$this->addHtmlAttr('id', $nameOnForm);
			$this->addCssClass(str_replace('_', '-', $nameOnForm));
			$this->addHtmlAttr('name', $nameOnForm . '[]');
		}

		/**
		 * Shows the html markup of the control.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function html()
		{

			$values = $this->getValue();

			if( !empty($values) ) {
				$values = explode('{%spr%}', $values);
			} else {
				$values = array();
			}

			?>
			<div class="factory-multiple-textbox-group">
				<div class="factory-mtextbox-items">
					<?php if( empty($values) ): ?>
						<div class="factory-mtextbox-item">
							<input <?php $this->attrs() ?>/>
						</div>
					<?php else: ?>
						<?php $counter = 0; ?>
						<?php foreach($values as $value): ?>
							<div class="factory-mtextbox-item">
								<input value="<?= esc_attr($value) ?>"<?php $this->attrs() ?>/>
								<?php if( $counter >= 1 ): ?>
									<button class="btn btn-default btn-small factory-mtextbox-remove-item">
										<i class="fa fa-times" aria-hidden="true"></i></button>
								<?php endif; ?>
							</div>
							<?php $counter++; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<button class="btn btn-default btn-small factory-mtextbox-add-item">
					<i class="fa fa-plus" aria-hidden="true"></i> <?php _e('Add new', 'factory_forms_000') ?>
				</button>
			</div>

		<?php
		}

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
				$value = array_map('sanitize_text_field', $value);
				$value = implode('{%spr%}', $value);
			}

			$value = sanitize_text_field($value);

			return $value;
		}
	}
