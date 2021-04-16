<?php

function inputElement ($icon, $placeholder, $name, $value) {
    $element = '
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text bg-warning">' . 
                $icon . 
            '</span>
        </div>

        <input type="text" name="' . $name . '" value="' . $value . '" autocomplete="off" id="" placeholder="' . $placeholder . '" class="form-control form-control-lg">
    </div>';

    echo ($element);
}

function inputElementImg ($icon, $placeholder, $name, $value) {
    $element = '
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text bg-warning">' .
        $icon .
        '</span>
        </div>

        <input type="file" name="' . $name . '" value="' . $value . '" autocomplete="off" id="" placeholder="' . $placeholder . '" class="form-control form-control-lg">
    </div>';

    echo ($element);
}

function buttonElement ($btnid, $styleclass, $text, $name, $attr) {
    $btn = '
    <button name="' . $name . '" class="' . $styleclass . '"' . $attr . ' id="' . $btnid . '">' . $text . '</button>';

    echo ($btn);
}

function textareaElement ($icon, $placeholder, $name) {
    $element = '
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text bg-warning">' . 
                $icon . 
            '</span>
        </div>

        <textarea name="' . $name . '" autocomplete="off" id="" placeholder="' . $placeholder . '" class="form-control form-control-lg"></textarea>
    </div>';

    echo ($element);
}