<script>
    (function () {
        function bindSessionAnnouncementForms(root) {
            const scope = root || document;
            const feedback = document.getElementById('session-announcements-feedback');
            const wrapper = document.getElementById('session-announcements-wrapper');

            function showAlert(type, message) {
                if (!feedback) {
                    return;
                }

                feedback.innerHTML = `
                    <div class="alert alert-${type} alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                `;
            }

            scope.querySelectorAll('.js-session-announcement-form').forEach((form) => {
                if (form.dataset.bound === '1') {
                    return;
                }

                form.dataset.bound = '1';

                form.addEventListener('submit', async function (event) {
                    event.preventDefault();

                    const submitButton = form.querySelector('button[type="submit"]');
                    const originalText = submitButton ? submitButton.textContent : '';
                    const previousScrollY = window.scrollY || window.pageYOffset;
                    const csrfMeta = document.querySelector('meta[name="csrf-token"]');

                    if (!csrfMeta) {
                        showAlert('danger', 'No se encontró el token CSRF en la página.');
                        return;
                    }

                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.textContent = 'Procesando...';
                    }

                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': csrfMeta.getAttribute('content'),
                                'Accept': 'application/json',
                            },
                            body: new FormData(form),
                        });

                        const payload = await response.json();

                        if (!response.ok || !payload.ok) {
                            throw new Error(payload.message || 'No fue posible publicar el anuncio.');
                        }

                        form.reset();

                        if (wrapper && payload.html) {
                            wrapper.innerHTML = payload.html;
                        }

                        window.scrollTo({ top: previousScrollY, behavior: 'auto' });
                        showAlert('success', payload.message || 'Anuncio publicado correctamente.');
                    } catch (error) {
                        showAlert('danger', error.message || 'Ocurrió un error al publicar el anuncio.');
                    } finally {
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.textContent = originalText || 'Publicar';
                        }
                    }
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            bindSessionAnnouncementForms(document);
        });

        window.initSessionAnnouncements = bindSessionAnnouncementForms;
    })();
</script>