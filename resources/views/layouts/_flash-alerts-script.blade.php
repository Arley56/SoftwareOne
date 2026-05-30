<script>
    (function () {
        const AUTO_DISMISS_MS = 4000;

        function scheduleAlertDismiss(alertElement) {
            if (!alertElement || alertElement.dataset.autoDismissScheduled === '1') {
                return;
            }

            alertElement.dataset.autoDismissScheduled = '1';

            window.setTimeout(function () {
                if (!document.body.contains(alertElement)) {
                    return;
                }

                const bootstrapAlert = bootstrap.Alert.getOrCreateInstance(alertElement);
                bootstrapAlert.close();
            }, AUTO_DISMISS_MS);
        }

        function scanAlerts(root) {
            (root || document).querySelectorAll('.alert').forEach(scheduleAlertDismiss);
        }

        document.addEventListener('DOMContentLoaded', function () {
            scanAlerts(document);

            const observer = new MutationObserver(function (mutations) {
                mutations.forEach(function (mutation) {
                    mutation.addedNodes.forEach(function (node) {
                        if (!(node instanceof HTMLElement)) {
                            return;
                        }

                        if (node.classList.contains('alert')) {
                            scheduleAlertDismiss(node);
                        }

                        scanAlerts(node);
                    });
                });
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true,
            });
        });
    })();
</script>