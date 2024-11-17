// scripts.js
// Inventory Data Chart
const inventoryCtx = document.getElementById('inventoryChart').getContext('2d');
new Chart(inventoryCtx, {
  type: 'bar',
  data: {
    labels: ['Guitars', 'Pianos', 'Drums', 'Violins', 'Flutes'],
    datasets: [{
      label: 'Quantity',
      data: [15, 5, 8, 12, 20],
      backgroundColor: ['#007bff', '#28a745', '#ffc107', '#17a2b8', '#dc3545'],
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
  }
});

// User Roles Pie Chart
const userRoleCtx = document.getElementById('userRoleChart').getContext('2d');
new Chart(userRoleCtx, {
  type: 'pie',
  data: {
    labels: ['Admins', 'Staff', 'Super Admins'],
    datasets: [{
      data: [5, 10, 1],
      backgroundColor: ['#007bff', '#ffc107', '#28a745'],
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
  }
});
