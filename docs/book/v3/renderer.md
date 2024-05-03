# Renderer

A class that is able to parse the content of the flash messenger service in an HTML format.
It uses the TemplateInterface to parse a partial, sending to the partial template the messages, the service and the renderer itself.
There are also a twig extension provided in [dot-twigrenderer](https://github.com/dotkernel/dot-twigrenderer), for easy parsing of messages blocks.

Partial template example:

```twig
{% set classes = {'error': 'danger', 'info': 'info', 'warning': 'warning', 'success' : 'success'} %}
{% if dismissible is not defined %}
    {% set dismissible = false %}
{% endif %}

{% if messages is defined and messages is iterable %}
    {% for namespace in messages|keys %}
        {% if classes[namespace] is defined %}

            <div class="alert alert-{{ classes[namespace] }} {% if dismissible %}alert-dismissible{% endif %}"
                 role="alert">

                {% if dismissible %}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                {% endif %}

                <ul>
                    {% for message in messages[namespace] %}
                        {% set writeMessage = message|raw %}
                        <li>{% trans writeMessage %}</li>
                    {% endfor %}
                </ul>

            </div>
        {% endif %}
    {% endfor %}
{% endif %}
```
