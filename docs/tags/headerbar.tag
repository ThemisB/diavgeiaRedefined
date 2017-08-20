<headerbar>
  <div class="container">
    <!-- Navbar -->
    <nav class="navbar">
      <div class="navbar-brand">
        <a class="navbar-item dvgRedefined logo" href="./index.html">Diavgeia Redefined</a>
        <div class="navbar-burger burger" data-target="navMenu" onclick="document.querySelector('.navbar-menu').classList.toggle('is-active');">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <div class="navbar-menu" id="navMenu">
        <div class="navbar-end">
          <div class="navbar-item">
            <a class="nav-item is-tab noDecoration" href="https://github.com/eellak/gsoc17-diavgeia" target="_blank"><img src="./images/octocat.png">&nbsp;Github</a>
          </div>
          <div class="navbar-item">
            <a class="nav-item is-tab noDecoration" href="https://eellak.ellak.gr/" target="_blank"><img src="./images/gfoss2.png">&nbsp;GFOSS</a>
          </div>
          <div class="navbar-item">
          <!-- TODO Change to archive link after final evaluation -->
          <a class="nav-item is-tab noDecoration" href="https://summerofcode.withgoogle.com/projects/#6340447621349376" target="_blank">&nbsp;<img src="./images/gsoc.png">GSoC Project</a>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <!-- Main Section -->
  <section class="hero is-primary">
    <div class="hero-body">
      <div class="container">
        <div class="columns is-vcentered">
          <div class="column">
            <p class="title">Redefined functionality of <a href="https://diavgeia.gov.gr/">Diavgeia</a></p>
            <p class="subtitle">Using RDF and Blockchain {element}</p>
          </div>
        </div>
      </div>
    </div>
    <div class="hero-foot">
      <div class="container">
        <nav class="tabs is-boxed">
          <ul>
            <li class={opts.page === 'overview' ? 'is-active' : '' }>
              <a href="/index.html">Overview</a>
            </li>
            <li class={opts.page === 'rdf' ? 'is-active' : '' }>
              <a href="/n3-composer.html">RDF</a>
            </li>
            <li class={opts.page === 'blockchain' ? 'is-active' : '' }>
              <a href="/blockchain.html">Blockchain</a>
            </li>
            <li class={opts.page === 'futurework' ? 'is-active' : '' }>
              <a href="/futurework.html">Future Work</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </section>
  <nav class="navbar has-shadow">
    <div class="container">
      <div class="navbar-brand" if={opts.page === 'overview'}>
        <a class="navbar-item is-tab {opts.subpage === 'whatisdiavgeia' ? 'is-active' : '' }" href="/index.html">What is Diavgeia?</a>
        <a class="navbar-item is-tab {opts.subpage === 'diavgeiaRedefined' ? 'is-active' : '' }" href="/diavgeiaRedefined.html">What is <span class="dvgRedefined dvgTab">Diavgeia Redefined</span>&nbsp;?</a>
      </div>
      <div class="navbar-brand" if={opts.page === 'rdf'}>
        <a class="navbar-item is-tab {opts.subpage === 'n3-composer' ? 'is-active' : '' }" href="/n3-composer.html">N3-Composer</a>
        <a class="navbar-item is-tab {opts.subpage === 'visualizer' ? 'is-active' : '' }" href="/visualizer.html">Visualizer</a>
        <a class="navbar-item is-tab {opts.subpage === 'sparql-endpoint' ? 'is-active' : '' }" href="/sparql-endpoint.html">SPARQL Endpoint</a>
        <a class="navbar-item is-tab {opts.subpage === 'rdfschema' ? 'is-active' : '' }" href="/rdf-schema.html">RDF Schema</a>
      </div>
      <div class="navbar-brand" if={opts.page === 'blockchain'}>
        <a class="navbar-item is-tab {opts.subpage === 'bitcoin' ? 'is-active' : '' }" href="/blockchain.html">Bitcoin</a>
      </div>
      <div class="navbar-brand" if={opts.page === 'futurework'}>
        <a class="navbar-item is-tab {opts.subpage === 'futurework' ? 'is-active' : '' }" href="/futurework.html">Future Work</a>
      </div>
    </div>
  </nav>
</headerbar>