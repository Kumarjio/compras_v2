<?php
echo "<?php\n\n";

echo "\$table_style = \"border-width: 1px;border-spacing: 2px;border-style: outset;border-color: gray;border-collapse: collapse;background-color: white;\";\n";
echo "\$td_style = \"border-width: 1px;padding: 3px;border-style: dotted;border-color: gray;background-color: white;\";";

echo "\n\n?>";
?>

<table style="<?php echo '<?php echo $table_style; ?>'?>">
  <tr>
	<?php
	foreach($this->tableSchema->columns as $column)
	{
		echo " <td style=\"<?php echo \$td_style; ?>\"><?php echo {$this->modelClass}::model()->getAttributeLabel(\"$column->name\"); ?></td>\n";
	}
	?>
  </tr>
  
    <?php echo "<?php foreach(\$model as \$m): ?>\n\n"; ?>
    <tr>
	<?php
	foreach($this->tableSchema->columns as $column)
	{
		echo " <td style=\"<?php echo \$td_style; ?>\"><?php echo \$m->{$column->name}; ?></td>\n";
	}
	?>
	</tr>
	<?php echo "<?php endforeach; ?>\n\n"; ?>
</table>


