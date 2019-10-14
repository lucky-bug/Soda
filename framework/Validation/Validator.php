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
    private $fields = [];
    
    /**
     * @getter
     * @setter
     */
    private $rules = [];

    /**
     * @getter
     */
    private $validFields = [];

    /**
     * @getter
     */
    private $errors = [];
    
    /**
     * @getter
     */
    private $valid = false;

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
            $value = trim($ruleParts[1]) ?? null;

            switch ($name) {
                case 'required':
                    $valid &= isset($this->fields[$fieldName]);
                    $this->addError($fieldName, 'This field is required!');
                    break;
                case 'numeric':
                    $valid &= is_numeric($this->fields[$fieldName]);
                    $this->addError($fieldName, 'Must be numeric!');
                    break;
                case 'min':
                    $valid &= (is_numeric($this->fields[$fieldName]) && $this->fields[$fieldName] >= $value);
                    $this->addError($fieldName, "Must be bigger than or equal to {$value}!");
                    break;
                case 'max':
                    $valid &= (is_numeric($this->fields[$fieldName]) && $this->fields[$fieldName] <= $value);
                    $this->addError($fieldName, "Must be less than or equal to {$value}!");
                    break;
                case 'int':
                case 'integer':
                    $valid &= filter_var($this->fields[$fieldName], FILTER_VALIDATE_INT) !== false;
                    $this->addError($fieldName, 'Must be integer!');
                    break;
                case 'bool':
                case 'boolean':
                    $valid &= filter_var($this->fields[$fieldName], FILTER_VALIDATE_BOOLEAN | FILTER_NULL_ON_FAILURE) !== null;
                    $this->addError($fieldName, 'Must be boolean!');
                    break;
                case 'email':
                    $valid &= filter_var($this->fields[$fieldName], FILTER_VALIDATE_EMAIL) !== false;
                    $this->addError($fieldName, 'Must be an email!');
                    break;
                case 'str':
                case 'string':
                    $valid &= is_string($this->fields[$fieldName]);
                    $this->addError($fieldName, 'Must be a string!');
                    break;
                case 'length':
                    $valid &= (strlen($this->fields[$fieldName]) == $value);
                    $this->addError($fieldName, "Must be {$value} characters long!");
                    break;
                case 'min-length':
                    $valid &= (strlen($this->fields[$fieldName]) >= $value);
                    $this->addError($fieldName, "Must have at least {$value} characters!");
                    break;
                case 'max-length':
                    $valid &= (strlen($this->fields[$fieldName]) <= $value);
                    $this->addError($fieldName, "Must have at most {$value} characters!");
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