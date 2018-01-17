<?php

	/**
	 * Datepicker range control
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 22.11.2017, Webcraftic
	 *
	 * Example:
	 * 'type' => 'datetimepicker-range',
	 * 'name' => 'facebook_start_date_filter',
	 * 'range_1' => array(
	 *     'format' => 'YYYY/MM/DD HH:mm',
	 *     'default' => date('Y/m/d H:i', strtotime('-1 week'))
	 * ),
	 * 'range_2' => array(
	 *     'format' => 'YYYY/MM/DD HH:mm',
	 *     'default' => date('Y/m/d H:i')
	 * ),
	 * 'title' => __('Выберите период', 'wpcr-scrapes'),
	 * 'hint' => __('Если Вкл., вы сможете установить настройки выбора записей за установленный период времени.', 'wpcr-scrapes')
	 *
	 * @package factory-forms
	 * @since 1.0.0
	 */
	class FactoryForms000_DatepickerRangeControl extends FactoryForms000_ComplexControl {

		public $type = 'datetimepicker-range';

		public function __construct($options, $form, $provider = null)
		{
			parent::__construct($options, $form, $provider);

			if( !isset($options['range_1']) ) {
				$options['range_1'] = array();
			}

			$options['range_1'] = array_merge(array(
				'scope' => isset($options['scope'])
					? $options['scope']
					: 'factory',
				'name' => $this->options['name'] . '__range_1',
				'format' => 'YYYY/MM/DD HH:mm',
				'default' => date('Y/m/d H:i')
			), $options['range_1']);

			if( !isset($options['range_2']) ) {
				$options['range_2'] = array();
			}

			$options['range_2'] = array_merge(array(
				'scope' => isset($options['scope'])
					? $options['scope']
					: 'factory',
				'name' => $this->options['name'] . '__range_2',
				'format' => 'YYYY/MM/DD HH:mm',
				'default' => date('Y/m/d H:i', strtotime("+1 month"))
			), $options['range_2']);

			$this->range_1 = new FactoryForms000_TextboxControl($options['range_1'], $form, $provider);
			$this->range_2 = new FactoryForms000_TextboxControl($options['range_2'], $form, $provider);
			$this->innerControls = array($this->range_1, $this->range_2);

			foreach($this->innerControls as $key => $control) {
				$control->addCssClass('factory-datetimepicker-range-' . $key);
				$control->addHtmlAttr('data-date-show-today-button', 'true');
				$control->addHtmlAttr('data-date-show-clear', 'true');

				$format = $control->getOption('format');

				if( !empty($format) ) {
					//'YYYY/MM/DD HH:mm'
					$control->addHtmlAttr('data-date-format', $format);
				}

				$locale_parts = explode('_', get_locale());

				$locale = isset($locale_parts[0])
					? $locale_parts[0]
					: 'en';

				$control->addHtmlAttr('data-date-locale', $locale);
			}
		}

		public function render()
		{
			?>
			<div class='input-group date factory-datetimepicker-input-group' style="display:inline-block; width: 200px">
				<?php $this->range_1->render(); ?>
			</div>
			<div class='input-group date factory-datetimepicker-input-group' style="display:inline-block; width: 200px">
				<?php $this->range_2->render(); ?>
			</div>
		<?php
		}
	}
