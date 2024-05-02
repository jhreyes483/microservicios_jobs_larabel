function formatDateTime(dateTimeString) {
    const options = {
      year: "numeric",
      month: "long",
      day: "numeric",
      hour: "numeric",
      minute: "numeric",
      second: "numeric",
      timeZoneName: "short"
    };
    const dateTime = new Date(dateTimeString);
    return dateTime.toLocaleString("es-ES", options);
  }
  export default formatDateTime;