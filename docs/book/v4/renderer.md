# Renderer

`Dot\FlashMessenger\View\FlashMessengerRenderer` turns the messages into HTML. The container has it as the `Dot\FlashMessenger\View\RendererInterface` service.

[dot-twigrenderer](https://github.com/dotkernel/dot-twigrenderer) gives two Twig functions that use this renderer: `messages()` calls `render()`, and `messagesPartial()` calls `renderPartial()`.

## render()

`render(?string $type = null, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL)` returns one HTML list for each message type. It escapes each message and each type name.

```php
$renderer->render();
```

```html
<ul class="flash-messages flash-messages-error"><li>The form has errors.</li></ul><ul class="flash-messages flash-messages-info"><li>Check your email.</li></ul>
```

With a type, it returns only the list of that type. If there are no messages, it returns an empty string.

## renderPartial()

`renderPartial(string $partial, array $params = [], ?string $type = null, string $channel = FlashMessengerInterface::DEFAULT_CHANNEL)` renders your template with `Mezzio\Template\TemplateRendererInterface`. The template gets these variables, and also the values in `$params`:

| Variable | Value |
| --- | --- |
| `messages` | The result of `getMessages($type, $channel)` |
| `messenger` | The `FlashMessengerInterface` service |
| `renderer` | The renderer |

Partial template example:

```twig
{% set classes = {'error': 'danger', 'info': 'info', 'warning': 'warning', 'success': 'success'} %}
{% if dismissible is not defined %}
    {% set dismissible = false %}
{% endif %}

{% if messages is defined and messages is iterable %}
    {% for type in messages|keys %}
        {% if classes[type] is defined %}
            <div class="alert alert-{{ classes[type] }} {% if dismissible %}alert-dismissible{% endif %}" role="alert">
                {% if dismissible %}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                {% endif %}
                <ul>
                    {% for message in messages[type] %}
                        <li>{{ message }}</li>
                    {% endfor %}
                </ul>
            </div>
        {% endif %}
    {% endfor %}
{% endif %}
```

Do not use the `raw` filter on a message. A message can contain user input, for example a user name. Without escaping, that input goes into the page as HTML. If you translate the messages, make sure that the translated text is escaped too.
