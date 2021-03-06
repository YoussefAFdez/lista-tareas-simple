<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class TareaUnica extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'La tarea con descripción "{{ value }}" ya existe.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
