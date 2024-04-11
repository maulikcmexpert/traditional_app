<!-- -----header-breadcrumb-start-- -->
<div class="header-breadcrumb">
    <h5>Dashboard</h5>
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">

            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
</div>
<!-- -----header-breadcrumb-end-- -->

<!-- ----our-total-info-start--- -->
<div class="our-total-info">
    <div class="row">
        <!-- <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-3">
            <div class="common-card Total Revenue">
                <h3>34,152</h3>
                <p>Total Revenue</p>
                <h6>
                    <span class="up">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                            <mask id="mask0_0_1111" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="15" height="15">
                                <rect y="0.300049" width="14.4" height="14.4" fill="white" />
                            </mask>
                            <g mask="url(#mask0_0_1111)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.00009 12.3001H5.40009V7.50014H2.49609L7.20009 2.79614L11.9041 7.50014H9.00009V12.3001Z" fill="#34C38F" />
                            </g>
                        </svg>
                        2.65%
                    </span>
                    since last week
                </h6>
                <div class="extra-img">
                    <svg xmlns="http://www.w3.org/2000/svg" width="67" height="35" viewBox="0 0 67 35" fill="none">
                        <rect x="64" y="14" width="3" height="21" fill="#304FFD" fill-opacity="0.85098" />
                        <rect x="57" y="19" width="3" height="16" fill="#304FFD" fill-opacity="0.85098" />
                        <rect x="51" y="21" width="3" height="14" fill="#304FFD" fill-opacity="0.85098" />
                        <rect x="44" y="27" width="3" height="8" fill="#304FFD" fill-opacity="0.85098" />
                        <rect x="38" y="18" width="3" height="17" fill="#304FFD" fill-opacity="0.85098" />
                        <rect x="32" y="25" width="3" height="10" fill="#304FFD" fill-opacity="0.85098" />
                        <rect x="25" y="10" width="3" height="25" fill="#304FFD" fill-opacity="0.85098" />
                        <rect x="19" width="3" height="35" fill="#304FFD" fill-opacity="0.85098" />
                        <rect x="13" y="19" width="3" height="16" fill="#304FFD" fill-opacity="0.85098" />
                        <rect x="6" y="9" width="3" height="26" fill="#304FFD" fill-opacity="0.85098" />
                        <rect y="25" width="3" height="10" fill="#304FFD" fill-opacity="0.85098" />
                    </svg>
                </div>
            </div>
        </div> -->

    </div>
</div>
<!-- ---our-total-info-end--- -->


<script>
    // Sample data for demonstration
    const dataAllYear = [ /* Your data for all year */ ];
    const dataOneYearAgo = [ /* Your data for one year ago */ ];
    const dataThisMonth = [ /* Your data for this month */ ];
    const dataToday = [ /* Your data for today */ ];

    // Get the canvas element
    const ctx = document.getElementById('myChart').getContext('2d');

    // Create the chart
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['All Year', 'One Year Ago', 'This Month', 'Today'],
            datasets: [{
                    label: 'Previous Data',
                    data: [ /* Your previous data for each time period */ ],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'Current Data',
                    data: [ /* Your current data for each time period */ ],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    fill: false
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>