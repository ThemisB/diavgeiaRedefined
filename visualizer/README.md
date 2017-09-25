# Visualizer

> Visualizer is a Node.js application that citizens or government institutions can use, in order to visualize .n3 decisions in their web browsers.

## Build Setup

``` bash
# install n3-composer dependencies
$ npm install
# Open visualizer
$ node index.js
```

## Usage Instructions

Visualizer takes two `GET` parameters (namely `decisionFolder` and `iun`) on `visualize` route. For demonstration reasons, a `const DECISIONS_DIRECTORY` is set in `index.js (line:9)` to point to [rdf samples folder](https://github.com/eellak/gsoc17-diavgeia/tree/master/rdf/samples) and it is something that the current production code of Diavgeia should change according to its needs.

For instance, a call to `localhost:3333/visualize?decisionFolder=Appointment&iun=ΨΟΗΩ46ΨΖΣ4-Ι56`, will result to the visualization of this `.n3` [appointment decision](https://github.com/eellak/gsoc17-diavgeia/blob/master/rdf/samples/Appointment/%CE%A8%CE%9F%CE%97%CE%A946%CE%A8%CE%96%CE%A34-%CE%9956.n3), as follows:

![Visualization of an appointment decision](http://image.ibb.co/g1Y0U5/visualization.png)