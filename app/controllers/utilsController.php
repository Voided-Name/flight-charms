<?php

namespace app\controllers;

class utilsController
{

  public static function insertAttribute($html, $tag, $attribute)
  {
    $pattern = "/(<$tag\b[^>]*)(>)/i";
    $replacement = "$1 $attribute$2";
    return preg_replace($pattern, $replacement, $html);
  }

  public static function renderNumberInput($id, $name, $label, $required = false, $placeholder = '', $value = '', $md, $sm)
  {
    $requiredAttr = $required ? 'required' : '';
    return "
    <div class='col-md-$md col-sm-$sm'>
      <label for='$id' class='form-label'>$label</label>
      <input type='number' class='form-control' id='$id' name='$name' value='$value' placeholder='$placeholder' $requiredAttr>
    </div>
    ";
  }

  public static function renderPasswordInput($id, $name, $label, $required = false, $placeholder = '', $value = '', $md, $sm)
  {
    $requiredAttr = $required ? 'required' : '';
    return "
    <div class='col-md-$md col-sm-$sm'>
      <label for='$id' class='form-label'>$label</label>
      <input type='password' class='form-control' id='$id' name='$name' value='$value' placeholder='$placeholder' $requiredAttr>
    </div>
    ";
  }

  public static function renderTextInput($id, $name, $label, $required = false, $placeholder = '', $value = '', $md, $sm)
  {
    $requiredAttr = $required ? 'required' : '';
    return "
    <div class='col-md-$md col-sm-$sm'>
      <label for='$id' class='form-label'>$label</label>
      <input type='text' class='form-control' id='$id' name='$name' value='$value' placeholder='$placeholder' $requiredAttr>
    </div>
    ";
  }

  public static function renderDateInput($id, $name, $label, $required = false, $placeholder = '', $value = '', $md, $sm)
  {
    $requiredAttr = $required ? 'required' : '';
    return "
    <div class='col-md-$md col-sm-$sm'>
      <label for='$id' class='form-label'>$label</label>
      <input type='date' class='form-control' id='$id' name='$name' value='$value' placeholder='$placeholder' $requiredAttr>
    </div>
    ";
  }

  public static function renderSelect($id, $name, $label, $required = false, $md, $sm)
  {
    $requiredAttr = $required ? 'required' : '';
    return "
    <div class='col-md-$md col-sm-$sm'>
      <label for='$id' class='form-label'>$label</label>
      <select class='form-select' id='$id' name='$name' $requiredAttr>
      </select>
    </div>
    ";
  }
  public static function renderSelectWithOptions($id, $name, $label, $options, $selectedValue = null)
  {
    $selectHtml = "<div class='col-md-4 col-sm-12'><label for='$id' class='form-label'>$label</label><select class='form-select' id='$id' name='$name'>";
    foreach ($options as $option) {
      $selected = ($option['value'] === $selectedValue) ? 'selected' : '';
      $selectHtml .= "<option value='{$option[' value']}' $selected>{$option['name']}</option>";
    }
    $selectHtml .= "</select></div>";
    return $selectHtml;
  }
}
