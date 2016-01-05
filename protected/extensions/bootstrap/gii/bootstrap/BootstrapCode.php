<?php
/**
 * BootstrapCode class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('gii.generators.crud.CrudCode');

class BootstrapCode extendS CrudCode
{
	public function generateActiveRow($modelClass, $column)
	{
		if ($column->type === 'boolean')
			return "\$form->checkBox(\$model,'{$column->name}',array('class'=>'form-control'))";
		else if (stripos($column->dbType,'text') !== false)
			return "\$form->textArea(\$model,'{$column->name}',array('class'=>'form-control'))";
		else
		{
			if (preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='passwordField';
			else
				$inputField='textField';

			if ($column->type!=='string' || $column->size===null)
				return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'form-control'))";
			else
				return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'form-control','maxlength'=>$column->size))";
		}
	}

	public function generateActiveLabel($modelClass, $column)
	{
		return "\$form->labelEx(\$model,'{$column->name}', array('class' => 'control-label'))";
	}

	public function generateActiveError($modelClass, $column)
	{
		return "\$form->error(\$model,'{$column->name}')";
	}
}
