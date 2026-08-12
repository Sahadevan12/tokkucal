function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content ?? '';
}

/**
 * POST a plain object as JSON and parse the JSON response.
 * Throws an object { status, errors, message } on 4xx/5xx so callers
 * can render field-level validation errors returned by Laravel.
 */
export async function postJson(url, data) {
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            'X-CSRF-TOKEN': csrfToken(),
        },
        body: JSON.stringify(data),
    });

    const body = await response.json().catch(() => ({}));

    if (!response.ok) {
        throw { status: response.status, errors: body.errors ?? {}, message: body.message ?? 'Something went wrong.' };
    }

    return body;
}

/**
 * POST a FormData payload (file uploads) and parse the JSON response.
 * Same error contract as postJson().
 */
export async function postForm(url, formData) {
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            Accept: 'application/json',
            'X-CSRF-TOKEN': csrfToken(),
        },
        body: formData,
    });

    const body = await response.json().catch(() => ({}));

    if (!response.ok) {
        throw { status: response.status, errors: body.errors ?? {}, message: body.message ?? 'Something went wrong.' };
    }

    return body;
}

/** Render Laravel validation errors ({field: [messages]}) into calculator-input error slots. */
export function showFieldErrors(errors) {
    Object.entries(errors).forEach(([field, messages]) => {
        const el = document.getElementById(`${field}-error`);
        if (el) {
            el.textContent = Array.isArray(messages) ? messages[0] : messages;
            el.classList.remove('hidden');
        }
    });
}

export function clearFieldErrors(form) {
    form.querySelectorAll('[id$="-error"]').forEach((el) => {
        el.textContent = '';
        el.classList.add('hidden');
    });
}
