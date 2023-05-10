<?php

namespace zedsh\tower\Fields\Default;

use zedsh\tower\Enums\Fields\MessageFieldStyle;
use zedsh\tower\Fields\ViewFormField;

class MessageField extends ViewFormField
{
    protected string $template = 'tower::fields.message';
    protected MessageFieldStyle $style = MessageFieldStyle::INFO;

    public function __construct(protected string $message = '', protected string $title = '')
    {
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param MessageFieldStyle $style
     * @return $this
     */
    public function setStyle(MessageFieldStyle $style): self
    {
        $this->style = $style;
        return $this;
    }

    /**
     * @return MessageFieldStyle
     */
    public function getStyle(): MessageFieldStyle
    {
        return $this->style;
    }
}
