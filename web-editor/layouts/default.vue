<template>
  <div>
    <nav role="navigation" aria-label="main navigation" class="navbar">
      <div class="container">
        <div class="navbar-brand">
          <a href="/" class="navbar-item" style="font-family: 'Pacifico', cursive;font-size: 30px"><strong>🏠 Diavgeia Redefined</strong></a>
          <button data-target="navMenu" class="button navbar-burger"><span></span><span></span><span></span></button>
        </div>
        <div id="navMenu" class="navbar-menu">
          <div class="navbar-start">
            <div class="navbar-item">
              <a class="nav-item is-tab noDecoration" href="/navigation">Περιήγηση Αποφάσεων</a>
            </div>
            <!-- <a href="localhost:3030/dataset.html?tab=query&ds=/decisions">SPARQL endpoint</a> -->
          </div>
          <div class="navbar-end">
            <div class="navbar-item">
              <a class="nav-item is-tab noDecoration" href="https://github.com/themisb/diavgeiaRedefined" target="_blank">
                <img src="../assets/octocat.png">&nbsp;Github</a>
            </div>
            <div class="navbar-item">
              <a class="nav-item is-tab noDecoration" href="http://kr.di.uoa.gr/" target="_blank">KRR&amp;A project</a>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <nuxt/>
  </div>
</template>
