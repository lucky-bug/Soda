<?php

namespace Soda\Validation;

use Soda\Core\Base;
use Soda\Validation\Exception\ValidationException;

class Validator extends Base
{
    /**
     * @getter
     * @setter
     */
    protected $fields = [];
    
    /**
     * @getter
     * @setter
     */
    protected  $rules = [];

    /**
     * @getter
     */
    protected $validFields = [];

    /**
     * @getter
     */
    protected $errors = [];
    
    /**
     * @getter
     */
    protected $valid = false;

    public function validate(): bool
    {
        $result = true;

        foreach ($this->rules as $field => $rules) {
            if (!$this->validateSingleField($field, explode('|', $rules))) {
                $result = false;
            } else {
                $this->validFields[$field] = $this->fields[$field];
            }
        }

        return $result;
    }

    public function validateSingleField(string $fieldName, array $rules): bool
    {
        $valid = true;

        foreach ($rules as $rule) {
            $ruleParts = explode(':', $rule);
            $name = $ruleParts[0] ?? '';
            $value = isset($ruleParts[1]) ? trim($ruleParts[1]) : null;

            switch ($name) {
                case 'required':
                    $test = isset($this->fields[$fieldName]) && strlen($this->fields[$fieldName]) > 0;
                    $valid &= $test;
                    
                    if (!$test) {
                        $this->addError($fieldName, 'This field is required!');
                    }
                    
                    break;
                case 'numeric':
                    $test = is_numeric($this->fields[$fieldName]);
                    $valid &= $test;
                    
                    if (!$test) {
                        $this->addError($fieldName, 'Must be numeric!');
                    }

                    break;
                case 'min':
                    $test = (is_numeric($this->fields[$fieldName]) && $this->fields[$fieldName] >= $value);
                    $valid &= $test;
                    
                    if (!$test) {
                        $this->addError($fieldName, "Must be bigger than or equal to {$value}!");
                    }

                    break;
                case 'max':
                    $test = (is_numeric($this->fields[$fieldName]) && $this->fields[$fieldName] <= $value);
                    $valid &= $test;
                    
                    if (!$test) {
                        $this->addError($fieldName, "Must be less than or equal to {$value}!");
                    }

                    break;
                case 'int':
                case 'integer':
                    $test = filter_var($this->fields[$fieldName], FILTER_VALIDATE_INT) !== false;
                    $valid &= $test;
                    
                    if (!$test) {
                        $this->addError($fieldName, 'Must be integer!');
                    }

                    break;
                case 'bool':
                case 'boolean':
                    $test = filter_var($this->fields[$fieldName], FILTER_VALIDATE_BOOLEAN | FILTER_NULL_ON_FAILURE) !== null;
                    $valid &= $test;
                    
                    if (!$test) {
                        $this->addError($fieldName, 'Must be boolean!');
                    }

                    break;
                case 'email':
                    $test = filter_var($this->fields[$fieldName], FILTER_VALIDATE_EMAIL) !== false;
                    $valid &= $test;
                    
                    if (!$test) {
                        $this->addError($fieldName, 'Must be an email!');
                    }

                    break;
                case 'str':
                case 'string':
                    $test = is_string($this->fields[$fieldName]);
                    $valid &= $test;
                    
                    if (!$test) {
                        $this->addError($fieldName, 'Must be a string!');
                    }

                    break;
                case 'length':
                    $test = (strlen($this->fields[$fieldName]) == $value);
                    $valid &= $test;
                    
                    if (!$test) {
                        $this->addError($fieldName, "Must be {$value} characters long!");
                    }

                    break;
                case 'min-length':
                    $test = (strlen($this->fields[$fieldName]) >= $value);
                    $valid &= $test;
                    
                    if (!$test) {
                        $this->addError($fieldName, "Must have at least {$value} characters!");
                    }

                    break;
                case 'max-length':
                    $test = (strlen($this->fields[$fieldName]) <= $value);
                    $valid &= $test;
                    
                    if (!$test) {
                        $this->addError($fieldName, "Must have at most {$value} characters!");
                    }

                    break;
                default:
                    throw new ValidationException('Invalid validation rule!');
                    break;
            }
        }

        return $valid;
    }

    private function addError(string $field, string $error): self
    {
        if(!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }

        $this->errors[$field][] = $error;

        return $this;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }
}