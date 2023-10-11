enum AlertType {
    INFO,
    SUCCESS,
    ERROR,
    WARNING,
}

type Alert = {
    message: string;
    type: AlertType;
};

const alerts = ref<Alert[]>([]);

function pushAlert(alert: Alert) {
    alerts.value.push(alert);

    setTimeout(() => removeAlert(alert), 3000);
}

function removeAlert(alert: Alert) {
    const index = alerts.value.indexOf(alert);
    if (index !== -1) {
        alerts.value.splice(index, 1);
    }
}

export type { Alert };
export { AlertType, alerts, pushAlert, removeAlert };
