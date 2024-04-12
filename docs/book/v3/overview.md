# Overview

`dot-flashmessenger` is a library for session messages, between redirects.

A flash message, or session message is a piece of text data that survives one requests(available only in the next request).

This library accepts session data as well, not just string messages, with the same behaviour.

The flash messenger is a convenient way to add data to the session and get it back on the next request without bothering with setting and clearing the data manually.