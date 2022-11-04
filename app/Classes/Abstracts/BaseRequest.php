<?php

namespace App\Classes\Abstracts;

use App\Classes\Interfaces\IFieldValidator;
use ErrorException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return $this->rules ?? [];
    }

    public function messages()
    {
        return $this->messages ?? [];
    }

    protected function validators(): array
    {
        return [];
    }

    protected array $rules = [];
    protected array $messages = [];

    /**
     * @throws ErrorException
     */
    public function withValidator(\Illuminate\Validation\Validator $validator)
    {
        $this->rules = $this->rules();
        $this->messages = $this->messages();
        if (!empty($this->validators())) {
            foreach ($this->validators() as $item) {
                $object = is_object($item) ? $item : new $item([]);
                if (!$object instanceof IFieldValidator) throw new ErrorException();
                $this->prepareMessages($object);
                $this->prepareRules($object);
                $this->prepareOptions($object);
            }
            $validator->addRules($this->rules);
        }
    }


    private function prepareOptions(IFieldValidator $object)
    {
        if ($object->required) $this->rules[$object->name][] = 'required';
        if ($object->nullable) $this->rules[$object->name][] = 'nullable';
    }

    private function prepareMessages(IFieldValidator $object)
    {
        $messages = $object->messages();
        foreach ($messages as $key => $message) {
            $messages[implode('.', [$object->getName(), $key])] = $message;
            unset($messages[$key]);
        }
        $this->messages = array_merge($this->messages, $messages);
    }

    private function prepareRules(IFieldValidator $object)
    {
        if (isset($this->rules[$object->getName()])) {
            if (is_array($this->rules[$object->getName()])) {
                $this->rules[$object->getName()] = array_merge($this->rules[$object->getName()], $object->rules());
            } else {
                $this->rules[$object->getName()] = $this->rules[$object->getName()] . '|' . implode('|', $object->rules());
            }
        } else {
            $this->rules[$object->getName()] = $object->rules();
        }
        $this->rules[$object->getName()] = array_merge($this->rules[$object->getName()], $object->getAdditionalRules());
    }
}
