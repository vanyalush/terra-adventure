// AJAX form validation for booking form
document.addEventListener('DOMContentLoaded', () => {
    const bookingForm = document.getElementById('booking-form');
    if (!bookingForm) return;

    const submitBtn = bookingForm.querySelector('[type="submit"]');

    bookingForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors();

        submitBtn.disabled = true;
        submitBtn.textContent = 'Отправка...';

        const data = new FormData(bookingForm);

        try {
            const response = await fetch(bookingForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: data,
            });

            if (response.ok) {
                const result = await response.json();
                window.location.href = result.redirect ?? '/cabinet';
                return;
            }

            if (response.status === 422) {
                const json = await response.json();
                showErrors(json.errors ?? {});
            } else {
                alert('Произошла ошибка. Попробуйте ещё раз.');
            }
        } catch {
            alert('Ошибка соединения. Попробуйте ещё раз.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Отправить заявку';
        }
    });

    function clearErrors() {
        bookingForm.querySelectorAll('.field-error').forEach(el => el.remove());
        bookingForm.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
        bookingForm.querySelectorAll('.date-error').forEach(el => el.remove());
    }

    function showErrors(errors) {
        for (const [field, messages] of Object.entries(errors)) {
            const input = bookingForm.querySelector(`[name="${field}"]`);
            const errorText = Array.isArray(messages) ? messages[0] : messages;

            if (input) {
                input.classList.add('input-error');
                const el = document.createElement('div');
                el.className = 'field-error';
                el.textContent = errorText;
                input.closest('.form-row')?.appendChild(el) ?? input.after(el);
            } else if (field === 'hike_date_id') {
                const section = bookingForm.querySelector('.date-section');
                if (section) {
                    const el = document.createElement('div');
                    el.className = 'field-error date-error';
                    el.textContent = errorText;
                    section.appendChild(el);
                }
            }
        }

        bookingForm.querySelector('.field-error, .date-error')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});
