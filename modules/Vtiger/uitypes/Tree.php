<?php

/**
 * UIType Tree Field Class.
 *
 * @copyright YetiForce Sp. z o.o
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Vtiger_Tree_UIType extends Vtiger_Base_UIType
{
	/**
	 * {@inheritdoc}
	 */
	public function validate($value, $isUserFormat = false)
	{
		if ($this->validate || empty($value)) {
			return;
		}
		if (substr($value, 0, 1) !== 'T' || !is_numeric(substr($value, 1))) {
			throw new \App\Exceptions\Security('ERR_ILLEGAL_FIELD_VALUE||' . $this->getFieldModel()->getFieldName() . '||' . $value, 406);
		}
		$this->validate = true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDisplayValue($value, $record = false, $recordModel = false, $rawText = false, $length = false)
	{
		$fieldModel = $this->getFieldModel();
		if ($rawText) {
			$text = \App\Fields\Tree::getPicklistValue($fieldModel->getFieldParams(), $fieldModel->getModuleName())[$value];
			if (is_int($length)) {
				$text = \App\TextParser::textTruncate($text, $length);
			}

			return \App\Purifier::encodeHtml($text);
		}
		$value = \App\Fields\Tree::getPicklistValueImage($fieldModel->getFieldParams(), $fieldModel->getModuleName(), $value);
		$text = $value['name'];
		if (is_int($length)) {
			$text = \App\TextParser::textTruncate($text, $length);
		}
		if (isset($value['icon'])) {
			return $value['icon'] . '' . \App\Purifier::encodeHtml($text);
		}

		return \App\Purifier::encodeHtml($text);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getListSearchTemplateName()
	{
		return 'List/Field/Tree.tpl';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getTemplateName()
	{
		return 'Edit/Field/Tree.tpl';
	}

	/**
	 * {@inheritdoc}
	 */
	public function isAjaxEditable()
	{
		return false;
	}
}
