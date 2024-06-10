'use strict';
{
    document.addEventListener('DOMContentLoaded', () => {
        const d = new Date();
        const dateInput = document.querySelector('#date');
        const timeInput = document.querySelector('#time');
        const numberInput = document.querySelector('#number');
        const numberDisplay = document.querySelector('.number');

        const formattedDate = d.toISOString().split('T')[0];
        dateInput.value = formattedDate;
        timeInput.value = "12:00";
        numberInput.value = "1";

        updateReservationData();
        dateInput.addEventListener('input', updateReservationData);
        timeInput.addEventListener('input', updateReservationData);
        numberInput.addEventListener('input', updateReservationData);

        function updateReservationData() {
            document.querySelector('.reservation-data__table--text-date').textContent = dateInput.value;
            document.querySelector('.reservation-data__table--text-time').textContent = timeInput.value;
            document.querySelector('.reservation-data__table--text-number').textContent = numberInput.value + "人";
        }
    });
}
