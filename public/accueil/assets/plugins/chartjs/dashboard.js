
setTimeout(function () {

	// chart 1
	var ctx1 = document.getElementById('chart1').getContext('2d');
	var myChart1 = new Chart(ctx1, {
		type: 'line',
		data: {
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"],
			datasets: [{
				label: 'New Visitor',
				data: [3, 3, 8, 5, 7, 4, 6, 4, 6, 3],
				backgroundColor: '#14abef',
				borderColor: "transparent",
				pointRadius :"0",
				borderWidth: 3
			}, {
				label: 'Old Visitor',
				data: [7, 5, 14, 7, 12, 6, 10, 6, 11, 5],
				backgroundColor: "rgba(20, 171, 239, .35)",
				borderColor: "transparent",
				pointRadius :"0",
				borderWidth: 1
			}]
		},
		options: {
			maintainAspectRatio: false,
			legend: {
				display: false,
				labels: {
					fontColor: '#585757',
					boxWidth:40
				}
			},
			tooltips: {
				displayColors:false
			},
			scales: {
				xAxes: [{
					ticks: {
						beginAtZero:true,
						fontColor: '#585757'
					},
					gridLines: {
						display: true ,
						color: "rgba(0, 0, 0, .05)"
					},
				}],
				yAxes: [{
					ticks: {
						beginAtZero:true,
						fontColor: '#585757'
					},
					gridLines: {
						display: true ,
						color: "rgba(0, 0, 0, .05)"
					},
				}]
			}

		}
	});


	// // chart 2
	// var ctx2 = document.getElementById("chart2").getContext('2d');
	// var myChart2 = new Chart(ctx2, {
	// 	type: 'doughnut',
	// 	data: {
	// 		labels: ["Direct", "Affiliate", "E-mail", "Other"],
	// 		datasets: [{
	// 			backgroundColor: [
	// 				"#14abef",
	// 				"#02ba5a",
	// 				"#d13adf",
	// 				"#fba540"
	// 			],
	// 			data: [5856, 2602, 1802, 1105],
	// 			borderWidth: [0, 0, 0, 0]
	// 		}]
	// 	},
	// 	options: {
	// 		maintainAspectRatio: false,
	// 		legend: {
	// 			position :"bottom",
	// 			display: false,
	// 			labels: {
	// 				fontColor: '#ddd',
	// 				boxWidth:15
	// 			}
	// 		}
	// 		,
	// 		tooltips: {
	// 			displayColors:false
	// 		}
	// 	}
	// });

}, 1000)


document.addEventListener('DOMContentLoaded', function() {
	fetch('/status-chart-data')
		.then(response => response.json())
		.then(data => {
			var ctx = document.getElementById('statusChart').getContext('2d');
			var statusChart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: data.labels,
					datasets: [
						{
							label: 'Pending',
							data: data.pending,
							borderColor: 'rgba(255, 99, 132, 1)',
							backgroundColor: 'rgba(255, 99, 132, 0.2)',
							borderWidth: 2,
							fill: true,
						},
						{
							label: 'Delivrés',
							data: data.valide,
							borderColor: 'rgba(54, 162, 235, 1)',
							backgroundColor: 'rgba(54, 162, 235, 0.2)',
							borderWidth: 2,
							fill: true,
						},
						{
							label: 'Echoués',
							data: data.close,
							borderColor: 'rgba(255, 206, 86, 1)',
							backgroundColor: 'rgba(255, 206, 86, 0.2)',
							borderWidth: 2,
							fill: true,
						}
					]
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
					scales: {
						x: {
							ticks: {
								beginAtZero: true,
								color: '#585757'
							},
							grid: {
								display: true,
								color: "rgba(0, 0, 0, .05)"
							}
						},
						y: {
							beginAtZero: true,
							ticks: {
								color: '#585757'
							},
							grid: {
								display: true,
								color: "rgba(0, 0, 0, .05)"
							}
						}
					},
					plugins: {
						legend: {
							display: true,
							labels: {
								color: '#585757'
							}
						},
						tooltip: {
							displayColors: false
						}
					}
				}
			});
		})
		.catch(error => console.error('Erreur de chargement des données:', error));
});
// ************************************************************DoughnutChart*************************

document.addEventListener('DOMContentLoaded', function() {
    // Function to fetch status counts
    function fetchStatusCounts() {
        fetch('/get-status-counts')
            .then(response => response.json())
            .then(data => {
                // Update chart with fetched data
                updateDoughnutChart(data);
            })
            .catch(error => console.error('Error fetching status counts:', error));
    }

    // Function to create or update the doughnut chart
    function updateDoughnutChart(data) {
        const ctx = document.getElementById('statusDoughnutChart').getContext('2d');
        
        // Destroy existing chart if it exists
        if (window.statusChart instanceof Chart) {
            window.statusChart.destroy();
        }

        // Create new chart
        window.statusChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Valide', 'Close'],
                datasets: [{
                    data: [data.pending, data.valide, data.close],
                    backgroundColor: [
                        'rgba(255, 206, 86)',  // Yellow for Pending
                        'rgba(0, 128, 0, 0.9)',  // Green for Valide
                        'rgba(255, 99, 132)'   // Red for Close
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
					
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Sender Status Distribution'
                    }
                }
            }
        });
    }

    // Initial fetch and setup periodic updates
    fetchStatusCounts();
    setInterval(fetchStatusCounts, 60000); // Update every minute
});


    
// *************************************************************************************************
document.addEventListener('DOMContentLoaded', function() {
    function updateStatusStatistics() {
        fetch('/dashboard')
            .then(response => response.json())
            .then(data => {
                // Mettre à jour les compteurs
                document.getElementById('total-senders').textContent = data.total.count;
                document.getElementById('pending-senders').textContent = data.pending.count;
                document.getElementById('valid-senders').textContent = data.valide.count;
                document.getElementById('closed-senders').textContent = data.close.count;

                // Mettre à jour les progress bars
                document.getElementById('total-progress-bar').style.width = `${data.total.percentage}%`;
                document.getElementById('pending-progress-bar').style.width = `${data.pending.percentage}%`;
                document.getElementById('valid-progress-bar').style.width = `${data.valide.percentage}%`;
                document.getElementById('closed-progress-bar').style.width = `${data.close.percentage}%`;
            });
    }

    // Mise à jour initiale
    updateStatusStatistics();

    // Actualisation périodique (toutes les 5 minutes)
    setInterval(updateStatusStatistics, 5 * 60 * 1000);
});



// ***********************************btn search page search

const searchBtn = document.getElementById('searchBtn');
const searchWindow = document.getElementById('searchWindow');
const closeBtn = document.getElementById('closeBtn');// Close search window
// Open search window
searchBtn.addEventListener('click', () => {
    searchWindow.style.display = 'flex';
});

closeBtn.addEventListener('click', () => {
    searchWindow.style.display = 'none';
    searchResult.innerHTML = ''; // Clear results on close
});

 // Fonction d'exportation des données (format CSV)
 document.getElementById('exportBtn').addEventListener('click', () => {
            const rows = document.querySelectorAll('.result tr');
            let csvContent = "data:text/csv;charset=utf-8,";

            rows.forEach(row => {
                let cols = row.querySelectorAll('td, th');
                let rowData = Array.from(cols).map(col => col.innerText).join(",");
                csvContent += rowData + "\r\n";
            });

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "exported_data.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
// *********************************************************************************************

document.addEventListener('DOMContentLoaded', function() {
	// Initialisation des dropdowns Bootstrap
	var dropdowns = document.querySelectorAll('.dropdown-toggle');
	dropdowns.forEach(function(dropdown) {
		new bootstrap.Dropdown(dropdown);
	});

	// Ajout d'une animation au hover (optionnel)
	const exportBtn = document.querySelector('#exportDropdown');
	if (exportBtn) {
		exportBtn.addEventListener('mouseover', function() {
			this.classList.add('shadow-sm');
		});
		exportBtn.addEventListener('mouseout', function() {
			this.classList.remove('shadow-sm');
		});
	}

	// Gestion du click sur les options d'export
	document.querySelectorAll('.dropdown-item').forEach(function(item) {
		item.addEventListener('click', function(e) {
			// Ajout d'un effet de chargement lors du clic
			const btn = document.querySelector('#exportDropdown');
			const originalText = btn.innerHTML;
			btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Exportation...';
			
			// Restauration du texte original après 2 secondes
			setTimeout(function() {
				btn.innerHTML = originalText;
			}, 2000);
		});
	});
});

// *************************************************************************************************************

// **********************************************btn edit and delete
function showOptions(id) {
	document.getElementById(`optionsMenu${id}`).style.display = 'block';
}

function openEditModal(id) {
	// Récupérer les données de l'utilisateur
	fetch(`/get-show/${id}`)
		.then(response => response.json())
		.then(user => {
			document.getElementById('id').value = user.id;
			document.getElementById('name').value = user.name;
			document.getElementById('country').value = user.country;
			document.getElementById('status').value = user.status;
			document.getElementById('operator').value = user.operator;
			
			// Afficher la modale
			document.getElementById('editModal').style.display = 'block';
		});
}

function closeEditModal() {
	document.getElementById('editModal').style.display = 'none';
}

function saveChanges() {
	const id = document.getElementById('id').value;
	const data = {
		_token: '{{ csrf_token() }}',
		name: document.getElementById('name').value,
		country: document.getElementById('country').value,
		status: document.getElementById('status').value,
		operator: document.getElementById('operator').value
	};

	fetch(`/get-put/${id}`, {
		method: 'PUT',
		headers: { 'Content-Type': 'application/json' },
		body: JSON.stringify(data)
	})
	.then(response => response.json())
	.then(data => {
		if (data.success) {
			alert("Mise à jour réussie !");
			closeEditModal();
			location.reload();
		} else {
			alert("Erreur lors de la mise à jour.");
		}
	});
}

function deleteUser(id) {
	if (confirm("are you sure?")) {
		fetch(`/get-destroy/${id}`, {
			method: 'DELETE',
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}'
			}
		})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				alert("Sender deleted !");
				location.reload();
			} else {
				alert("Erreur lors de la suppression.");
			}
		});
	}
}
