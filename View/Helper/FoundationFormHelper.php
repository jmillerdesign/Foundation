<?php
App::uses('FormHelper', 'View/Helper');
App::uses('Set', 'Utility');

class FoundationFormHelper extends FormHelper {

	public $helpers = array('Html');

	public function create($model = null, $options = array()) {
		$options += array('class' => 'nice');
		return parent::create($model, $options);
	}

	public function input($fieldName, $options = array()) {
	
		if(isset($options['label']) && $options['label'] != false){
			$options['label']['class'] = 'five columns right inline';		
		}
		
		$options +=  array(
			'div' => 'row row-block',
			'class' => 'four columns end',
			'error' => array('attributes' => array('wrap' => 'small', 'class' => 'error four columns offset-by-five')),
		);

		if ($options['class'] !== 'input-text') {
			$options['class'] .=  ' input-text';
		}

		if (!empty($options['error']) && empty($options['error']['attributes']['wrap'])) {	
			$options['error']['attributes']['wrap'] = 'small';
		}
		if (isset($options['image_path'])) {
			$options['between'] = '<img src="' . $options['image_path'] . '" width="100px">';			
		}
		
		return parent::input($fieldName, $options);
	}
	
	public function submit($caption = NULL, $options = array()) {
		$options += array(
			'div' => array(
				'class' => 'row row-block button-block'
				),
			'class' => 'button round'
			);
		$button = parent::button($caption, $options);	
		return $this->Html->div('row row-block button-block', $this->Html->div('twelve columns', $button));
	}


	protected function _selectOptions($elements = array(), $parents = array(), $showParents = null, $attributes = array()) {
		$select = array();
		$attributes = array_merge(
			array('escape' => true, 'style' => null, 'value' => null, 'class' => null),
			$attributes
		);
		$selectedIsEmpty = ($attributes['value'] === '' || $attributes['value'] === null);
		$selectedIsArray = is_array($attributes['value']);

		foreach ($elements as $name => $title) {
			$htmlOptions = array();
			if (is_array($title) && (!isset($title['name']) || !isset($title['value']))) {
				if (!empty($name)) {
					if ($attributes['style'] === 'checkbox') {
						$select[] = $this->Html->useTag('fieldsetend');
					} else {
						$select[] = $this->Html->useTag('optiongroupend');
					}
					$parents[] = $name;
				}
				$select = array_merge($select, $this->_selectOptions(
					$title, $parents, $showParents, $attributes
				));

				if (!empty($name)) {
					$name = $attributes['escape'] ? h($name) : $name;
					if ($attributes['style'] === 'checkbox') {
						$select[] = $this->Html->useTag('fieldsetstart', $name);
					} else {
						$select[] = $this->Html->useTag('optiongroup', $name, '');
					}
				}
				$name = null;
			} elseif (is_array($title)) {
				$htmlOptions = $title;
				$name = $title['value'];
				$title = $title['name'];
				unset($htmlOptions['name'], $htmlOptions['value']);
			}

			if ($name !== null) {

				if (
					(!$selectedIsArray && !$selectedIsEmpty && (string)$attributes['value'] == (string)$name) ||
					($selectedIsArray && in_array($name, $attributes['value']))
				) {
					if ($attributes['style'] === 'checkbox') {
						$htmlOptions['checked'] = true;
					} else {
						$htmlOptions['selected'] = 'selected';
					}
				}

				if ($showParents || (!in_array($title, $parents))) {
					$title = ($attributes['escape']) ? h($title) : $title;

					if ($attributes['style'] === 'checkbox') {
						$htmlOptions['value'] = $name;

						$tagName = $attributes['id'] . Inflector::camelize(Inflector::slug($name));
						$htmlOptions['id'] = $tagName;
						$label = array('for' => $tagName);

						if (isset($htmlOptions['checked']) && $htmlOptions['checked'] === true) {
							$label['class'] = 'selected';
						}

						$name = $attributes['name'];

						if (empty($attributes['class'])) {
							$attributes['class'] = 'checkbox';
						} elseif ($attributes['class'] === 'form-error') {
							$attributes['class'] = 'checkbox ' . $attributes['class'];
						}
						$item = $this->Html->useTag('checkboxmultiple', $name, $htmlOptions);
						$select[] = $this->label($htmlOptions['id'], $item . $title);
					} else {
						$select[] = $this->Html->useTag('selectoption', $name, $htmlOptions, $title);
					}
				}
			}
		}

		return array_reverse($select, true);
	}
}