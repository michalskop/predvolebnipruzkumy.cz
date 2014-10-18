// calculates exact binomial confidence intervals (4 decimal digits)
// http://statpages.org/confint.html

function CalcBinL(x,N,vTL,vTU) {
    vTL = typeof vTL !== 'undefined' ? vTL : 0.25;
    vTU = typeof vTU !== 'undefined' ? vTU : 0.25;
    var vx = x
    var vN = N
    var vP = vx/vN
    P= vP
    if(vx==0)
	{ DL = 0 } else
        { var v=vP/2; vsL=0; vsH=vP; var p=vTL
        while((vsH-vsL)>1e-5) { if(BinP(vN,v,vx,vN)>p) { vsH=v; v=(vsL+v)/2 } else { vsL=v; v=(v+vsH)/2 } }
        DL = v }

    return DL  
}

function CalcBinU(x,N,vTL,vTU) {
    vTL = typeof vTL !== 'undefined' ? vTL : 0.25;
    vTU = typeof vTU !== 'undefined' ? vTU : 0.25;
    var vx = x
    var vN = N
    var vP = vx/vN
    P= vP
    if(vx==vN)
        { DU = 1 } else
        { var v=(1+vP)/2; vsL=vP; vsH=1; var p=vTU
        while((vsH-vsL)>1e-5) { if(BinP(vN,v,0,vx)<p) { vsH=v; v=(vsL+v)/2 } else { vsL=v; v=(v+vsH)/2 } }
        DU = v }
    return DU
}
        
function BinP(N,p,x1,x2) {
    var q=p/(1-p); var k=0; var v = 1; var s=0; var tot=0
    while(k<=N) {
        tot=tot+v
        if(k>=x1 & k<=x2) { s=s+v }
        if(tot>1e30){s=s/1e30; tot=tot/1e30; v=v/1e30}
        k=k+1; v=v*q*(N+1-k)/k
        }
    return s/tot
    }

function Fmt(x) { 
var v
if(x>=0) { v=''+(x+0.00005) } else { v=''+(x-0.00005) }
return v.substring(0,v.indexOf('.')+5)
}
