<?php

@mkdir('../battleracer');
@mkdir('../battleracer/g');
@mkdir('../battleracer_practice');

@copy('../puyopuyo/db.php', '../battleracer/db.php');
@copy('../puyopuyo/.htaccess', '../battleracer/.htaccess');
@copy('../puyopuyo/clippy.c6b23471.svg', '../battleracer/clippy.c6b23471.svg');
@copy('../puyopuyo/g/clippy.png', '../battleracer/clippy.png');


$img = file_get_contents('https://i.imgur.com/e5Cn0hD.png');
file_put_contents('../battleracer/g/powerup1.png', $img);

$img = file_get_contents('https://i.imgur.com/z4NO2Qo.png');
file_put_contents('../battleracer/g/powerup2.png', $img);

$img = file_get_contents('https://i.imgur.com/JGeh2Ex.png');
file_put_contents('../battleracer/g/crosshair1.png', $img);

$img = file_get_contents('https://i.imgur.com/IwQT5we.png');
file_put_contents('../battleracer/g/crosshair2.png', $img);

$img = file_get_contents('https://i.imgur.com/iIKeTUQ.png');
file_put_contents('../battleracer/g/crosshair3.png', $img);

$img = file_get_contents('https://i.imgur.com/jIA0ac8.png');
file_put_contents('../mirrors/battleracerThumb.png', $img);

$img = file_get_contents('https://i.imgur.com/UzVzNpd.jpg');
file_put_contents('../battleracerThumb.jpg', $img);

$img = file_get_contents('https://i.imgur.com/pOgx39b.jpg');
file_put_contents('../battleracer/splash.jpg', $img);

$file = file_get_contents('https://whr.000.pe/battleracer_practice/car_no_wheels.obj');
file_put_contents('../battleracer/g/car_no_wheels.obj', $file);
file_put_contents('../battleracer_practice/car_no_wheels.obj', $file);

$file = file_get_contents('https://whr.000.pe/battleracer_practice/car_no_wheels_lowpoly.obj');
file_put_contents('../battleracer/g/car_no_wheels_lowpoly.obj', $file);
file_put_contents('../battleracer_practice/car_no_wheels_lowpoly.obj', $file);

$file = file_get_contents('https://whr.000.pe/battleracer_practice/car_wheel.obj');
file_put_contents('../battleracer/g/car_wheel.obj', $file);
file_put_contents('../battleracer_practice/car_wheel.obj', $file);

$file = file_get_contents('https://whr.000.pe/battleracer_practice/car_wheel_lowpoly.obj');
file_put_contents('../battleracer/g/car_wheel_lowpoly.obj', $file);
file_put_contents('../battleracer_practice/car_wheel_lowpoly.obj', $file);

$file = <<<'FILE'
<!DOCTYPE html>
<html>
  <head>
    <title>BATTLERACER singleplayer / practice arena</title>
    <style>
      /* latin-ext */
      @font-face {
        font-family: 'Courier Prime';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/courierprime/v9/u-450q2lgwslOqpF_6gQ8kELaw9pWt_-.woff2) format('woff2');
        unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
      }
      /* latin */
      @font-face {
        font-family: 'Courier Prime';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/courierprime/v9/u-450q2lgwslOqpF_6gQ8kELawFpWg.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
      }

      body,html{
        margin: 0;
        height: 100vh;
        overflow: hidden;
      }
      #c{
        background:#000;
        display: block;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
      }
      #c:focus{
        outline: none;
      }
    </style>
  </head>
  <body>
    <canvas id="c" tabindex=0></canvas>
    <script>
      /*  to do
      //   ✔ map rotate
      //   ✔ wheelie bug
      //   ✔ reverse turning (fix dir)
      //   ✔ reverse warning
      //   ✔ car deconstruct / reconstruct
      //   ✔ powerups
      //   ✔ car trails
      //   ✔ finish dashboard
      //   * player list / cam selection
      //   * configurable drift
      //   * menu
      //   * multiplayer / arena integration
      //
      //
      //
      //
      */

      c = document.querySelector('#c')
      c.width = 1920
      c.height = 1080
      x = c.getContext('2d')
      C = Math.cos
      S = Math.sin
      t = 0
      T = Math.tan

      rsz=window.onresize=()=>{
        setTimeout(()=>{
          if(document.body.clientWidth > document.body.clientHeight*1.77777778){
            c.style.height = '100vh'
            setTimeout(()=>c.style.width = c.clientHeight*1.77777778+'px',0)
          }else{
            c.style.width = '100vw'
            setTimeout(()=>c.style.height =     c.clientWidth/1.77777778 + 'px',0)
          }
        },0)
      }
      rsz()

      async function Draw(){
        oX=oY=oZ=0
        if(!t){
          HSVFromRGB = (R, G, B) => {
            let R_=R/256
            let G_=G/256
            let B_=B/256
            let Cmin = Math.min(R_,G_,B_)
            let Cmax = Math.max(R_,G_,B_)
            let val = Cmax //(Cmax+Cmin) / 2
            let delta = Cmax-Cmin
            let sat = Cmax ? delta / Cmax: 0
            let min=Math.min(R,G,B)
            let max=Math.max(R,G,B)
            let hue = 0
            if(delta){
              if(R>=G && R>=B) hue = (G-B)/(max-min)
              if(G>=R && G>=B) hue = 2+(B-R)/(max-min)
              if(B>=G && B>=R) hue = 4+(R-G)/(max-min)
            }
            hue*=60
            while(hue<0) hue+=360;
            while(hue>=360) hue-=360;
            return [hue, sat, val]
          }

          RGBFromHSV = (H, S, V) => {
            while(H<0) H+=360;
            while(H>=360) H-=360;
            let C = V*S
            let X = C * (1-Math.abs((H/60)%2-1))
            let m = V-C
            let R_, G_, B_
            if(H>=0 && H < 60)    R_=C, G_=X, B_=0
            if(H>=60 && H < 120)  R_=X, G_=C, B_=0
            if(H>=120 && H < 180) R_=0, G_=C, B_=X
            if(H>=180 && H < 240) R_=0, G_=X, B_=C
            if(H>=240 && H < 300) R_=X, G_=0, B_=C
            if(H>=300 && H < 360) R_=C, G_=0, B_=X
            let R = (R_+m)*256
            let G = (G_+m)*256
            let B = (B_+m)*256
            return [R,G,B]
          }

          R=R2=(Rl,Pt,Yw,m)=>{
            M=Math
            X-=oX
            Y-=oY
            Z-=oZ
            A=M.atan2
            H=M.hypot
            X=S(p=A(X,Z)+Yw)*(d=H(X,Z))
            Z=C(p)*d
            Y=S(p=A(Y,Z)+Pt)*(d=H(Y,Z))
            Z=C(p)*d
            X=S(p=A(X,Y)+Rl)*(d=H(X,Y))
            Y=C(p)*d
          }
          R3=(Rl,Pt,Yw,m)=>{
            M=Math
            A=M.atan2
            H=M.hypot
            X=S(p=A(X,Y)+Rl)*(d=H(X,Y))
            Y=C(p)*d
            Y=S(p=A(Y,Z)+Pt)*(d=H(Y,Z))
            Z=C(p)*d
            X=S(p=A(X,Z)+Yw)*(d=H(X,Z))
            Z=C(p)*d
          }
          Q=()=>[c.width/2+X/Z*700,c.height/2+Y/Z*700]
          Q2=()=>[c.width/2+X/Z*1200,c.height/2+Y/Z*1200]
          I=(A,B,M,D,E,F,G,H)=>(K=((G-E)*(B-F)-(H-F)*(A-E))/(J=(H-F)*(M-A)-(G-E)*(D-B)))>=0&&K<=1&&(L=((M-A)*(B-F)-(D-B)*(A-E))/J)>=0&&L<=1?[A+K*(M-A),B+K*(D-B)]:0

          Rn = Math.random
          async function loadOBJ(url, scale, tx, ty, tz, rl, pt, yw) {
            let res
            await fetch(url, res => res).then(data=>data.text()).then(data=>{
              a=[]
              data.split("\nv ").map(v=>{
                a=[...a, v.split("\n")[0]]
              })
              a=a.filter((v,i)=>i).map(v=>[...v.split(' ').map(n=>(+n.replace("\n", '')))])
              ax=ay=az=0
              a.map(v=>{
                v[1]*=-1
                ax+=v[0]
                ay+=v[1]
                az+=v[2]
              })
              ax/=a.length
              ay/=a.length
              az/=a.length
              a.map(v=>{
                X=(v[0]-ax)*scale
                Y=(v[1]-ay)*scale
                Z=(v[2]-az)*scale
                R2(rl,pt,yw,0)
                v[0]=X
                v[1]=Y
                v[2]=Z
              })
              maxY=-6e6
              a.map(v=>{
                if(v[1]>maxY)maxY=v[1]
              })
              a.map(v=>{
                v[1]-=maxY-oY
                v[0]+=tx
                v[1]+=ty
                v[2]+=tz
              })

              b=[]
              data.split("\nf ").map(v=>{
                b=[...b, v.split("\n")[0]]
              })
              b.shift()
              b=b.map(v=>v.split(' '))
              b=b.map(v=>{
                v=v.map(q=>{
                  return +q.split('/')[0]
                })
                v=v.filter(q=>q)
                return v
              })

              res=[]
              b.map(v=>{
                e=[]
                v.map(q=>{
                  e=[...e, a[q-1]]
                })
                e = e.filter(q=>q)
                res=[...res, e]
              })
            })
            return res
          }

          geoSphere = (mx, my, mz, iBc, size) => {
            let collapse=0
            let B=Array(iBc).fill().map(v=>{
              X = Rn()-.5
              Y = Rn()-.5
              Z = Rn()-.5
              return  [X,Y,Z]
            })
            for(let m=200;m--;){
              B.map((v,i)=>{
                X = v[0]
                Y = v[1]
                Z = v[2]
                B.map((q,j)=>{
                  if(j!=i){
                    X2=q[0]
                    Y2=q[1]
                    Z2=q[2]
                    d=1+(Math.hypot(X-X2,Y-Y2,Z-Z2)*(3+iBc/40)*3)**4
                    X+=(X-X2)*99/d
                    Y+=(Y-Y2)*99/d
                    Z+=(Z-Z2)*99/d
                  }
                })
                d=Math.hypot(X,Y,Z)
                v[0]=X/d
                v[1]=Y/d
                v[2]=Z/d
                if(collapse){
                  d=25+Math.hypot(X,Y,Z)
                  v[0]=(X-X/d)/1.1
                  v[1]=(Y-Y/d)/1.1         
                  v[2]=(Z-Z/d)/1.1
                }
              })
            }
            mind = 6e6
            B.map((v,i)=>{
              X1 = v[0]
              Y1 = v[1]
              Z1 = v[2]
              B.map((q,j)=>{
                X2 = q[0]
                Y2 = q[1]
                Z2 = q[2]
                if(i!=j){
                  d = Math.hypot(a=X1-X2, b=Y1-Y2, e=Z1-Z2)
                  if(d<mind) mind = d
                }
              })
            })
            a = []
            B.map((v,i)=>{
              X1 = v[0]
              Y1 = v[1]
              Z1 = v[2]
              B.map((q,j)=>{
                X2 = q[0]
                Y2 = q[1]
                Z2 = q[2]
                if(i!=j){
                  d = Math.hypot(X1-X2, Y1-Y2, Z1-Z2)
                  if(d<mind*2){
                    if(!a.filter(q=>q[0]==X2&&q[1]==Y2&&q[2]==Z2&&q[3]==X1&&q[4]==Y1&&q[5]==Z1).length) a = [...a, [X1*size,Y1*size,Z1*size,X2*size,Y2*size,Z2*size]]
                  }
                }
              })
            })
            B.map(v=>{
              v[0]*=size
              v[1]*=size
              v[2]*=size
              v[0]+=mx
              v[1]+=my
              v[2]+=mz
            })
            return [mx, my, mz, size, B, a]
          }

          lineFaceI = (X1, Y1, Z1, X2, Y2, Z2, facet, autoFlipNormals=false, showNormals=false) => {
            let X_, Y_, Z_, d, m, l_,K,J,L,p
            let I_=(A,B,M,D,E,F,G,H)=>(K=((G-E)*(B-F)-(H-F)*(A-E))/(J=(H-F)*(M-A)-(G-E)*(D-B)))>=0&&K<=1&&(L=((M-A)*(B-F)-(D-B)*(A-E))/J)>=0&&L<=1?[A+K*(M-A),B+K*(D-B)]:0
            let Q_=()=>[c.width/2+X_/Z_*600,c.height/2+Y_/Z_*600]
            let R_ = (Rl,Pt,Yw,m)=>{
              let M=Math, A=M.atan2, H=M.hypot
              X_=S(p=A(X_,Y_)+Rl)*(d=H(X_,Y_)),Y_=C(p)*d,X_=S(p=A(X_,Z_)+Yw)*(d=H(X_,Z_)),Z_=C(p)*d,Y_=S(p=A(Y_,Z_)+Pt)*(d=H(Y_,Z_)),Z_=C(p)*d
              if(m){ X_+=oX,Y_+=oY,Z_+=oZ }
            }
            let rotSwitch = m =>{
              switch(m){
                case 0: R_(0,0,Math.PI/2); break
                case 1: R_(0,Math.PI/2,0); break
                case 2: R_(Math.PI/2,0,Math.PI/2); break
              }        
            }
            let ax = 0, ay = 0, az = 0
            facet.map(q_=>{ ax += q_[0], ay += q_[1], az += q_[2] })
            ax /= facet.length, ay /= facet.length, az /= facet.length
            let b1 = facet[2][0]-facet[1][0], b2 = facet[2][1]-facet[1][1], b3 = facet[2][2]-facet[1][2]
            let c1 = facet[1][0]-facet[0][0], c2 = facet[1][1]-facet[0][1], c3 = facet[1][2]-facet[0][2]
            let crs = [b2*c3-b3*c2,b3*c1-b1*c3,b1*c2-b2*c1]
            d = Math.hypot(...crs)+.001
            let nls = 1 //normal line length
            crs = crs.map(q=>q/d*nls)
            let X1_ = ax, Y1_ = ay, Z1_ = az
            let flip = 1
            if(autoFlipNormals){
              let d1_ = Math.hypot(X1_-X1,Y1_-Y1,Z1_-Z1)
              let d2_ = Math.hypot(X1-(ax + crs[0]/99),Y1-(ay + crs[1]/99),Z1-(az + crs[2]/99))
              flip = d2_>d1_?-1:1
            }
            let X2_ = ax + (crs[0]*=flip), Y2_ = ay + (crs[1]*=flip), Z2_ = az + (crs[2]*=flip)
            if(showNormals){
              x.beginPath()
              X_ = X1_, Y_ = Y1_, Z_ = Z1_
              R_(Rl,Pt,Yw,1)
              if(Z_>0) x.lineTo(...Q_())
              X_ = X2_, Y_ = Y2_, Z_ = Z2_
              R_(Rl,Pt,Yw,1)
              if(Z_>0) x.lineTo(...Q_())
              x.lineWidth = 5
              x.strokeStyle='#f004'
              x.stroke()
            }

            let p1_ = Math.atan2(X2_-X1_,Z2_-Z1_)
            let p2_ = -(Math.acos((Y2_-Y1_)/(Math.hypot(X2_-X1_,Y2_-Y1_,Z2_-Z1_)+.001))+Math.PI/2)
            let isc = false, iscs = [false,false,false]
            X_ = X1, Y_ = Y1, Z_ = Z1
            R_(0,-p2_,-p1_)
            let rx_ = X_, ry_ = Y_, rz_ = Z_
            for(let m=3;m--;){
              if(isc === false){
                X_ = rx_, Y_ = ry_, Z_ = rz_
                rotSwitch(m)
                X1_ = X_, Y1_ = Y_, Z1_ = Z_ = 5, X_ = X2, Y_ = Y2, Z_ = Z2
                R_(0,-p2_,-p1_)
                rotSwitch(m)
                X2_ = X_, Y2_ = Y_, Z2_ = Z_
                facet.map((q_,j_)=>{
                  if(isc === false){
                    let l = j_
                    X_ = facet[l][0], Y_ = facet[l][1], Z_ = facet[l][2]
                    R_(0,-p2_,-p1_)
                    rotSwitch(m)
                    let X3_=X_, Y3_=Y_, Z3_=Z_
                    l = (j_+1)%facet.length
                    X_ = facet[l][0], Y_ = facet[l][1], Z_ = facet[l][2]
                    R_(0,-p2_,-p1_)
                    rotSwitch(m)
                    let X4_ = X_, Y4_ = Y_, Z4_ = Z_
                    if(l_=I_(X1_,Y1_,X2_,Y2_,X3_,Y3_,X4_,Y4_)) iscs[m] = l_
                  }
                })
              }
            }
            if(iscs.filter(v=>v!==false).length==3){
              let iscx = iscs[1][0], iscy = iscs[0][1], iscz = iscs[0][0]
              let pointInPoly = true
              ax=0, ay=0, az=0
              facet.map((q_, j_)=>{ ax+=q_[0], ay+=q_[1], az+=q_[2] })
              ax/=facet.length, ay/=facet.length, az/=facet.length
              X_ = ax, Y_ = ay, Z_ = az
              R_(0,-p2_,-p1_)
              X1_ = X_, Y1_ = Y_, Z1_ = Z_
              X2_ = iscx, Y2_ = iscy, Z2_ = iscz
              facet.map((q_,j_)=>{
                if(pointInPoly){
                  let l = j_
                  X_ = facet[l][0], Y_ = facet[l][1], Z_ = facet[l][2]
                  R_(0,-p2_,-p1_)
                  let X3_ = X_, Y3_ = Y_, Z3_ = Z_
                  l = (j_+1)%facet.length
                  X_ = facet[l][0], Y_ = facet[l][1], Z_ = facet[l][2]
                  R_(0,-p2_,-p1_)
                  let X4_ = X_, Y4_ = Y_, Z4_ = Z_
                  if(I_(X1_,Y1_,X2_,Y2_,X3_,Y3_,X4_,Y4_)) pointInPoly = false
                }
              })
              if(pointInPoly){
                X_ = iscx, Y_ = iscy, Z_ = iscz
                R_(0,p2_,0)
                R_(0,0,p1_)
                isc = [[X_,Y_,Z_], [crs[0],crs[1],crs[2]]]
              }
            }
            return isc
          }

          TruncatedOctahedron = ls => {
            let shp = [], a = []
            mind = 6e6
            for(let i=6;i--;){
              X = S(p=Math.PI*2/6*i+Math.PI/6)*ls
              Y = C(p)*ls
              Z = 0
              if(Y<mind) mind = Y
              a = [...a, [X, Y, Z]]
            }
            let theta = .6154797086703867
            a.map(v=>{
              X = v[0]
              Y = v[1] - mind
              Z = v[2]
              R(0,theta,0)
              v[0] = X
              v[1] = Y
              v[2] = Z+1.5
            })
            b = JSON.parse(JSON.stringify(a)).map(v=>{
              v[1] *= -1
              return v
            })
            shp = [...shp, a, b]
            e = JSON.parse(JSON.stringify(shp)).map(v=>{
              v.map(q=>{
                X = q[0]
                Y = q[1]
                Z = q[2]
                R(0,0,Math.PI)
                q[0] = X
                q[1] = Y
                q[2] = Z
              })
              return v
            })
            shp = [...shp, ...e]
            e = JSON.parse(JSON.stringify(shp)).map(v=>{
              v.map(q=>{
                X = q[0]
                Y = q[1]
                Z = q[2]
                R(0,0,Math.PI/2)
                q[0] = X
                q[1] = Y
                q[2] = Z
              })
              return v
            })
            shp = [...shp, ...e]

            coords = [
              [[3,1],[4,3],[4,4],[3,2]],
              [[3,4],[3,3],[2,4],[6,2]],
              [[1,4],[0,3],[0,4],[4,2]],
              [[1,1],[1,2],[6,4],[7,3]],
              [[3,5],[7,5],[1,5],[3,0]],
              [[2,5],[6,5],[0,5],[4,5]]
            ]
            a = []
            coords.map(v=>{
              b = []
              v.map(q=>{
                X = shp[q[0]][q[1]][0]
                Y = shp[q[0]][q[1]][1]
                Z = shp[q[0]][q[1]][2]
                b = [...b, [X,Y,Z]]
              })
              a = [...a, b]
            })
            shp = [...shp, ...a]
            return shp.map(v=>{
              v.map(q=>{
                q[0]/=3
                q[1]/=3
                q[2]/=3
                q[0]*=ls
                q[1]*=ls
                q[2]*=ls
              })
              return v
            })
          }

          Cylinder = (rw,cl,ls1,ls2) => {
            let a = []
            for(let i=rw;i--;){
              let b = []
              for(let j=cl;j--;){
                X = S(p=Math.PI*2/cl*j) * ls1
                Y = (1/rw*i-.5)*ls2
                Z = C(p) * ls1
                b = [...b, [X,Y,Z]]
              }
              //a = [...a, b]
              for(let j=cl;j--;){
                b = []
                X = S(p=Math.PI*2/cl*j) * ls1
                Y = (1/rw*i-.5)*ls2
                Z = C(p) * ls1
                b = [...b, [X,Y,Z]]
                X = S(p=Math.PI*2/cl*(j+1)) * ls1
                Y = (1/rw*i-.5)*ls2
                Z = C(p) * ls1
                b = [...b, [X,Y,Z]]
                X = S(p=Math.PI*2/cl*(j+1)) * ls1
                Y = (1/rw*(i+1)-.5)*ls2
                Z = C(p) * ls1
                b = [...b, [X,Y,Z]]
                X = S(p=Math.PI*2/cl*j) * ls1
                Y = (1/rw*(i+1)-.5)*ls2
                Z = C(p) * ls1
                b = [...b, [X,Y,Z]]
                a = [...a, b]
              }
            }
            b = []
            for(let j=cl;j--;){
              X = S(p=Math.PI*2/cl*j) * ls1
              Y = ls2/2
              Z = C(p) * ls1
              b = [...b, [X,Y,Z]]
            }
            //a = [...a, b]
            return a
          }

          Tetrahedron = size => {
            ret = []
            a = []
            let h = size/1.4142/1.25
            for(i=3;i--;){
              X = S(p=Math.PI*2/3*i) * size/1.25
              Y = C(p) * size/1.25
              Z = h
              a = [...a, [X,Y,Z]]
            }
            ret = [...ret, a]
            for(j=3;j--;){
              a = []
              X = 0
              Y = 0
              Z = -h
              a = [...a, [X,Y,Z]]
              X = S(p=Math.PI*2/3*j) * size/1.25
              Y = C(p) * size/1.25
              Z = h
              a = [...a, [X,Y,Z]]
              X = S(p=Math.PI*2/3*(j+1)) * size/1.25
              Y = C(p) * size/1.25
              Z = h
              a = [...a, [X,Y,Z]]
              ret = [...ret, a]
            }
            ax=ay=az=ct=0
            ret.map(v=>{
              v.map(q=>{
                ax+=q[0]
                ay+=q[1]
                az+=q[2]
                ct++
              })
            })
            ax/=ct
            ay/=ct
            az/=ct
            ret.map(v=>{
              v.map(q=>{
                q[0]-=ax
                q[1]-=ay
                q[2]-=az
              })
            })
            return ret
          }

          Cube = size => {
            for(CB=[],j=6;j--;CB=[...CB,b])for(b=[],i=4;i--;)b=[...b,[(a=[S(p=Math.PI*2/4*i+Math.PI/4),C(p),2**.5/2])[j%3]*(l=j<3?size/1.5:-size/1.5),a[(j+1)%3]*l,a[(j+2)%3]*l]]
            return CB
          }

          Octahedron = size => {
            ret = []
            let h = size/1.25
            for(j=8;j--;){
              a = []
              X = 0
              Y = 0
              Z = h * (j<4?-1:1)
              a = [...a, [X,Y,Z]]
              X = S(p=Math.PI*2/4*j) * size/1.25
              Y = C(p) * size/1.25
              Z = 0
              a = [...a, [X,Y,Z]]
              X = S(p=Math.PI*2/4*(j+1)) * size/1.25
              Y = C(p) * size/1.25
              Z = 0
              a = [...a, [X,Y,Z]]
              ret = [...ret, a]
            }
            return ret      
          }

          Dodecahedron = size => {
            ret = []
            a = []
            mind = -6e6
            for(i=5;i--;){
              X=S(p=Math.PI*2/5*i + Math.PI/5)
              Y=C(p)
              Z=0
              if(Y>mind) mind=Y
              a = [...a, [X,Y,Z]]
            }
            a.map(v=>{
              X = v[0]
              Y = v[1]-=mind
              Z = v[2]
              R(0, .553573, 0)
              v[0] = X
              v[1] = Y
              v[2] = Z
            })
            b = JSON.parse(JSON.stringify(a))
            b.map(v=>{
              v[1] *= -1
            })
            ret = [...ret, a, b]
            mind = -6e6
            ret.map(v=>{
              v.map(q=>{
                X = q[0]
                Y = q[1]
                Z = q[2]
                if(Z>mind)mind = Z
              })
            })
            d1=Math.hypot(ret[0][0][0]-ret[0][1][0],ret[0][0][1]-ret[0][1][1],ret[0][0][2]-ret[0][1][2])
            ret.map(v=>{
              v.map(q=>{
                q[2]-=mind+d1/2
              })
            })
            b = JSON.parse(JSON.stringify(ret))
            b.map(v=>{
              v.map(q=>{
                q[2]*=-1
              })
            })
            ret = [...ret, ...b]
            b = JSON.parse(JSON.stringify(ret))
            b.map(v=>{
              v.map(q=>{
                X = q[0]
                Y = q[1]
                Z = q[2]
                R(0,0,Math.PI/2)
                R(0,Math.PI/2,0)
                q[0] = X
                q[1] = Y
                q[2] = Z
              })
            })
            e = JSON.parse(JSON.stringify(ret))
            e.map(v=>{
              v.map(q=>{
                X = q[0]
                Y = q[1]
                Z = q[2]
                R(0,0,Math.PI/2)
                R(Math.PI/2,0,0)
                q[0] = X
                q[1] = Y
                q[2] = Z
              })
            })
            ret = [...ret, ...b, ...e]
            ret.map(v=>{
              v.map(q=>{
                q[0] *= size/2
                q[1] *= size/2
                q[2] *= size/2
              })
            })
            return ret
          }

          Icosahedron = size => {
            ret = []
            let B = [
              [[0,3],[1,0],[2,2]],
              [[0,3],[1,0],[1,3]],
              [[0,3],[2,3],[1,3]],
              [[0,2],[2,1],[1,0]],
              [[0,2],[1,3],[1,0]],
              [[0,2],[1,3],[2,0]],
              [[0,3],[2,2],[0,0]],
              [[1,0],[2,2],[2,1]],
              [[1,1],[2,2],[2,1]],
              [[1,1],[2,2],[0,0]],
              [[1,1],[2,1],[0,1]],
              [[0,2],[2,1],[0,1]],
              [[2,0],[1,2],[2,3]],
              [[0,0],[0,3],[2,3]],
              [[1,3],[2,0],[2,3]],
              [[2,3],[0,0],[1,2]],
              [[1,2],[2,0],[0,1]],
              [[0,0],[1,2],[1,1]],
              [[0,1],[1,2],[1,1]],
              [[0,2],[2,0],[0,1]],
            ]
            for(p=[1,1],i=38;i--;)p=[...p,p[l=p.length-1]+p[l-1]]
            phi = p[l]/p[l-1]
            a = [
              [-phi,-1,0],
              [phi,-1,0],
              [phi,1,0],
              [-phi,1,0],
            ]
            for(j=3;j--;ret=[...ret, b])for(b=[],i=4;i--;) b = [...b, [a[i][j],a[i][(j+1)%3],a[i][(j+2)%3]]]
            ret.map(v=>{
              v.map(q=>{
                q[0]*=size/2.25
                q[1]*=size/2.25
                q[2]*=size/2.25
              })
            })
            cp = JSON.parse(JSON.stringify(ret))
            out=[]
            a = []
            B.map(v=>{
              idx1a = v[0][0]
              idx2a = v[1][0]
              idx3a = v[2][0]
              idx1b = v[0][1]
              idx2b = v[1][1]
              idx3b = v[2][1]
              a = [...a, [cp[idx1a][idx1b],cp[idx2a][idx2b],cp[idx3a][idx3b]]]
            })
            out = [...out, ...a]
            return out
          }

          stroke = (scol, fcol, lwo=1, od=true, oga=1) => {
            if(scol){
              x.closePath()
              if(od) x.globalAlpha = .2*oga
              x.strokeStyle = scol
              x.lineWidth = Math.min(1000,100*lwo/Z)
              if(od) x.stroke()
              x.lineWidth /= 4
              x.globalAlpha = 1*oga
              x.stroke()
            }
            if(fcol){
              x.globalAlpha = 1*oga
              x.fillStyle = fcol
              x.fill()
            }
            x.globalAlpha = 1
          }

          subbed = (subs, size, sphereize, shape) => {
            for(let m=subs; m--;){
              base = shape
              shape = []
              base.map(v=>{
                l = 0
                X1 = v[l][0]
                Y1 = v[l][1]
                Z1 = v[l][2]
                l = 1
                X2 = v[l][0]
                Y2 = v[l][1]
                Z2 = v[l][2]
                l = 2
                X3 = v[l][0]
                Y3 = v[l][1]
                Z3 = v[l][2]
                if(v.length > 3){
                  l = 3
                  X4 = v[l][0]
                  Y4 = v[l][1]
                  Z4 = v[l][2]
                  if(v.length > 4){
                    l = 4
                    X5 = v[l][0]
                    Y5 = v[l][1]
                    Z5 = v[l][2]
                  }
                }
                mx1 = (X1+X2)/2
                my1 = (Y1+Y2)/2
                mz1 = (Z1+Z2)/2
                mx2 = (X2+X3)/2
                my2 = (Y2+Y3)/2
                mz2 = (Z2+Z3)/2
                a = []
                switch(v.length){
                  case 3:
                    mx3 = (X3+X1)/2
                    my3 = (Y3+Y1)/2
                    mz3 = (Z3+Z1)/2
                    X = X1, Y = Y1, Z = Z1, a = [...a, [X,Y,Z]]
                    X = mx1, Y = my1, Z = mz1, a = [...a, [X,Y,Z]]
                    X = mx3, Y = my3, Z = mz3, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = mx1, Y = my1, Z = mz1, a = [...a, [X,Y,Z]]
                    X = X2, Y = Y2, Z = Z2, a = [...a, [X,Y,Z]]
                    X = mx2, Y = my2, Z = mz2, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = mx3, Y = my3, Z = mz3, a = [...a, [X,Y,Z]]
                    X = mx2, Y = my2, Z = mz2, a = [...a, [X,Y,Z]]
                    X = X3, Y = Y3, Z = Z3, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = mx1, Y = my1, Z = mz1, a = [...a, [X,Y,Z]]
                    X = mx2, Y = my2, Z = mz2, a = [...a, [X,Y,Z]]
                    X = mx3, Y = my3, Z = mz3, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    break
                  case 4:
                    mx3 = (X3+X4)/2
                    my3 = (Y3+Y4)/2
                    mz3 = (Z3+Z4)/2
                    mx4 = (X4+X1)/2
                    my4 = (Y4+Y1)/2
                    mz4 = (Z4+Z1)/2
                    cx = (X1+X2+X3+X4)/4
                    cy = (Y1+Y2+Y3+Y4)/4
                    cz = (Z1+Z2+Z3+Z4)/4
                    X = X1, Y = Y1, Z = Z1, a = [...a, [X,Y,Z]]
                    X = mx1, Y = my1, Z = mz1, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    X = mx4, Y = my4, Z = mz4, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = mx1, Y = my1, Z = mz1, a = [...a, [X,Y,Z]]
                    X = X2, Y = Y2, Z = Z2, a = [...a, [X,Y,Z]]
                    X = mx2, Y = my2, Z = mz2, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    X = mx2, Y = my2, Z = mz2, a = [...a, [X,Y,Z]]
                    X = X3, Y = Y3, Z = Z3, a = [...a, [X,Y,Z]]
                    X = mx3, Y = my3, Z = mz3, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = mx4, Y = my4, Z = mz4, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    X = mx3, Y = my3, Z = mz3, a = [...a, [X,Y,Z]]
                    X = X4, Y = Y4, Z = Z4, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    break
                  case 5:
                    cx = (X1+X2+X3+X4+X5)/5
                    cy = (Y1+Y2+Y3+Y4+Y5)/5
                    cz = (Z1+Z2+Z3+Z4+Z5)/5
                    mx3 = (X3+X4)/2
                    my3 = (Y3+Y4)/2
                    mz3 = (Z3+Z4)/2
                    mx4 = (X4+X5)/2
                    my4 = (Y4+Y5)/2
                    mz4 = (Z4+Z5)/2
                    mx5 = (X5+X1)/2
                    my5 = (Y5+Y1)/2
                    mz5 = (Z5+Z1)/2
                    X = X1, Y = Y1, Z = Z1, a = [...a, [X,Y,Z]]
                    X = X2, Y = Y2, Z = Z2, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = X2, Y = Y2, Z = Z2, a = [...a, [X,Y,Z]]
                    X = X3, Y = Y3, Z = Z3, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = X3, Y = Y3, Z = Z3, a = [...a, [X,Y,Z]]
                    X = X4, Y = Y4, Z = Z4, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = X4, Y = Y4, Z = Z4, a = [...a, [X,Y,Z]]
                    X = X5, Y = Y5, Z = Z5, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = X5, Y = Y5, Z = Z5, a = [...a, [X,Y,Z]]
                    X = X1, Y = Y1, Z = Z1, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    break
                }
              })
            }
            if(sphereize){
              ip1 = sphereize
              ip2 = 1-sphereize
              shape = shape.map(v=>{
                v = v.map(q=>{
                  X = q[0]
                  Y = q[1]
                  Z = q[2]
                  d = Math.hypot(X,Y,Z)
                  X /= d
                  Y /= d
                  Z /= d
                  X *= size*.75*ip1 + d*ip2
                  Y *= size*.75*ip1 + d*ip2
                  Z *= size*.75*ip1 + d*ip2
                  return [X,Y,Z]
                })
                return v
              })
            }
            return shape
          }

          subDividedIcosahedron  = (size, subs, sphereize = 0) => subbed(subs, size, sphereize, Icosahedron(size))
          subDividedTetrahedron  = (size, subs, sphereize = 0) => subbed(subs, size, sphereize, Tetrahedron(size))
          subDividedOctahedron   = (size, subs, sphereize = 0) => subbed(subs, size, sphereize, Octahedron(size))
          subDividedCube         = (size, subs, sphereize = 0) => subbed(subs, size, sphereize, Cube(size))
          subDividedDodecahedron = (size, subs, sphereize = 0) => subbed(subs, size, sphereize, Dodecahedron(size))

          Rn = Math.random

          LsystemRecurse = (size, splits, p1, p2, stem, theta, LsystemReduction, twistFactor) => {
            if(size < .25) return
            let X1 = stem[0]
            let Y1 = stem[1]
            let Z1 = stem[2]
            let X2 = stem[3]
            let Y2 = stem[4]
            let Z2 = stem[5]
            let p1a = Math.atan2(X2-X1,Z2-Z1)
            let p2a = -Math.acos((Y2-Y1)/(Math.hypot(X2-X1,Y2-Y1,Z2-Z1)+.0001))+Math.PI
            size/=LsystemReduction
            for(let i=splits;i--;){
              X = 0
              Y = -size
              Z = 0
              R(0, theta, 0)
              R(0, 0, Math.PI*2/splits*i+twistFactor)
              R(0, p2a, 0)
              R(0, 0, p1a+twistFactor)
              X+=X2
              Y+=Y2
              Z+=Z2
              let newStem = [X2, Y2, Z2, X, Y, Z]
              Lshp = [...Lshp, newStem]
              LsystemRecurse(size, splits, p1+Math.PI*2/splits*i+twistFactor, p2+theta, newStem, theta, LsystemReduction, twistFactor)
            }
          }
          DrawLsystem = shp => {
            shp.map(v=>{
              x.beginPath()
              X = v[0]
              Y = v[1]
              Z = v[2]
              R(Rl,Pt,Yw,1)
              if(Z>0)x.lineTo(...Q())
              X = v[3]
              Y = v[4]
              Z = v[5]
              R(Rl,Pt,Yw,1)
              if(Z>0)x.lineTo(...Q())
              lwo = Math.hypot(v[0]-v[3],v[1]-v[4],v[2]-v[5])*4
              stroke('#0f82','',lwo)
            })

          }
          Lsystem = (size, splits, theta, LsystemReduction, twistFactor) => {
            Lshp = []
            stem = [0,0,0,0,-size,0]
            Lshp = [...Lshp, stem]
            LsystemRecurse(size, splits, 0, 0, stem, theta, LsystemReduction, twistFactor)
            Lshp.map(v=>{
              v[1]+=size*1.5
              v[4]+=size*1.5
            })
            return Lshp
          }

          Sphere = (ls, rw, cl) => {
            a = []
            ls/=1.25
            for(j = rw; j--;){
              for(i = cl; i--;){
                b = []
                X = S(p = Math.PI*2/cl*i) * S(q = Math.PI/rw*j) * ls
                Y = C(q) * ls
                Z = C(p) * S(q) * ls
                b = [...b, [X,Y,Z]]
                X = S(p = Math.PI*2/cl*(i+1)) * S(q = Math.PI/rw*j) * ls
                Y = C(q) * ls
                Z = C(p) * S(q) * ls
                b = [...b, [X,Y,Z]]
                X = S(p = Math.PI*2/cl*(i+1)) * S(q = Math.PI/rw*(j+1)) * ls
                Y = C(q) * ls
                Z = C(p) * S(q) * ls
                b = [...b, [X,Y,Z]]
                X = S(p = Math.PI*2/cl*i) * S(q = Math.PI/rw*(j+1)) * ls
                Y = C(q) * ls
                Z = C(p) * S(q) * ls
                b = [...b, [X,Y,Z]]
                a = [...a, b]
              }
            }
            return a
          }

          Torus = (rw, cl, ls1, ls2, parts=1, twists=0, part_spacing=1.5) => {
            let ret = [], tx=0, ty=0, tz=0, prl1 = 0, p2a = 0
            let tx1 = 0, ty1 = 0, tz1 = 0, prl2 = 0, p2b = 0, tx2 = 0, ty2 = 0, tz2 = 0
            for(let m=parts;m--;){
              avgs = Array(rw).fill().map(v=>[0,0,0])
              for(j=rw;j--;)for(let i = cl;i--;){
                if(parts>1){
                  ls3 = ls1*part_spacing
                  X = S(p=Math.PI*2/parts*m) * ls3
                  Y = C(p) * ls3
                  Z = 0
                  R(prl1 = Math.PI*2/rw*(j-1)*twists,0,0)
                  tx1 = X
                  ty1 = Y 
                  tz1 = Z
                  R(0, 0, Math.PI*2/rw*(j-1))
                  ax1 = X
                  ay1 = Y
                  az1 = Z
                  X = S(p=Math.PI*2/parts*m) * ls3
                  Y = C(p) * ls3
                  Z = 0
                  R(prl2 = Math.PI*2/rw*(j)*twists,0,0)
                  tx2 = X
                  ty2 = Y
                  tz2 = Z
                  R(0, 0, Math.PI*2/rw*j)
                  ax2 = X
                  ay2 = Y
                  az2 = Z
                  p1a = Math.atan2(ax2-ax1,az2-az1)
                  p2a = Math.PI/2+Math.acos((ay2-ay1)/(Math.hypot(ax2-ax1,ay2-ay1,az2-az1)+.001))

                  X = S(p=Math.PI*2/parts*m) * ls3
                  Y = C(p) * ls3
                  Z = 0
                  R(Math.PI*2/rw*(j)*twists,0,0)
                  tx1b = X
                  ty1b = Y
                  tz1b = Z
                  R(0, 0, Math.PI*2/rw*j)
                  ax1b = X
                  ay1b = Y
                  az1b = Z
                  X = S(p=Math.PI*2/parts*m) * ls3
                  Y = C(p) * ls3
                  Z = 0
                  R(Math.PI*2/rw*(j+1)*twists,0,0)
                  tx2b = X
                  ty2b = Y
                  tz2b = Z
                  R(0, 0, Math.PI*2/rw*(j+1))
                  ax2b = X
                  ay2b = Y
                  az2b = Z
                  p1b = Math.atan2(ax2b-ax1b,az2b-az1b)
                  p2b = Math.PI/2+Math.acos((ay2b-ay1b)/(Math.hypot(ax2b-ax1b,ay2b-ay1b,az2b-az1b)+.001))
                }
                a = []
                X = S(p=Math.PI*2/cl*i) * ls1
                Y = C(p) * ls1
                Z = 0
                //R(0,0,-p1a)
                R(prl1,p2a,0)
                X += ls2 + tx1, Y += ty1, Z += tz1
                R(0, 0, Math.PI*2/rw*j)
                a = [...a, [X,Y,Z]]
                X = S(p=Math.PI*2/cl*(i+1)) * ls1
                Y = C(p) * ls1
                Z = 0
                //R(0,0,-p1a)
                R(prl1,p2a,0)
                X += ls2 + tx1, Y += ty1, Z += tz1
                R(0, 0, Math.PI*2/rw*j)
                a = [...a, [X,Y,Z]]
                X = S(p=Math.PI*2/cl*(i+1)) * ls1
                Y = C(p) * ls1
                Z = 0
                //R(0,0,-p1b)
                R(prl2,p2b,0)
                X += ls2 + tx2, Y += ty2, Z += tz2
                R(0, 0, Math.PI*2/rw*(j+1))
                a = [...a, [X,Y,Z]]
                X = S(p=Math.PI*2/cl*i) * ls1
                Y = C(p) * ls1
                Z = 0
                //R(0,0,-p1b)
                R(prl2,p2b,0)
                X += ls2 + tx2, Y += ty2, Z += tz2
                R(0, 0, Math.PI*2/rw*(j+1))
                a = [...a, [X,Y,Z]]
                ret = [...ret, a]
              }
            }
            return ret
          }

          G_ = 100000, iSTc = 1e4
          ST = Array(iSTc).fill().map(v=>{
            X = (Rn()-.5)*G_
            Y = (Rn()-.5)*G_
            Z = (Rn()-.5)*G_
            return [X,Y,Z]
          })

          burst = new Image()
          burst.src = "burst.png"
          
          powerupsLoaded = false, powerupImgs = [{loaded: false}]
          powerupImgs = Array(2).fill().map((v,i) => {
            let a = {img: new Image(), loaded: false}
            a.img.onload = () => {
              a.loaded = true
              setTimeout(()=>{
                if(powerupImgs.filter(v=>v.loaded).length == 2) powerupsLoaded = true
              }, 0)
            }
            a.img.src = `powerup${i+1}.png`
            return a
          })

          crosshairsLoaded = false, crosshairImgs = [{loaded: false}]
          crosshairImgs = Array(3).fill().map((v,i) => {
            let a = {img: new Image(), loaded: false}
            a.img.onload = () => {
              a.loaded = true
              setTimeout(()=>{
                if(crosshairImgs.filter(v=>v.loaded).length == 3) crosshairsLoaded = true
              }, 0)
            }
            a.img.src = `crosshair${i+1}.png`
            return a
          })

          starsLoaded = false, starImgs = [{loaded: false}]
          starImgs = Array(9).fill().map((v,i) => {
            let a = {img: new Image(), loaded: false}
            a.img.onload = () => {
              a.loaded = true
              setTimeout(()=>{
                if(starImgs.filter(v=>v.loaded).length == 9) starsLoaded = true
              }, 0)
            }
            a.img.src = `https://srmcgann.github.io/stars/star${i+1}.png`
            return a
          })

          floor = (X, Z) => {
            //return 0
            return ((50-Math.hypot(X,Z)/20-t*10)%50)
            return Math.max(0, C((d=Math.hypot(X, Z))/300)*200+((50-d/20-t*10)%50))
            //return (S(X/50+t*2) + S(Z/100))*4 * ((1+S(X/100+t)*C(Z/100))%1)*10 + ((S(X/1000)+C(Z/2000))*200)
            //return Math.min(20, Math.max(-20, S(X/500+t/2)*100 + S(Z/150+t)*100)) + ((S(X/400) + S(Z/200)) * ((1+S(X/100)*C(Z/100)))*10 + ((S(X/1000)+C(Z/2000))*200))
            //return Math.max(-2000, Math.min(2000, (C(Z/100)*25 + C(X/100)*25)**5/2e4))
            //return Math.max(-20,Math.min(20,100-(S(X/400+t/2+Math.hypot(X/400,Z/400))*150 * C(Z/400))))
            p = Math.atan2(X+=400, Z -= 800) + Math.PI/4
            d = Math.hypot(X, Z)
            X = S(p) * d
            Z = C(p) * d
            return Math.min(50, Math.max(-50, ((C(X/400) + S(Z/400))*10)**3/20))
          }
          
          spawnCar = (X=0, Y=0, Z=0) => {
            let car = {
              X,
              Y,
              Z,
              vx: 0,
              vy: 0,
              vz: 0,
              yw: 0,
              pt: 0,
              rl: 0,
              rlv: 0,
              ptv: 0,
              ywv: 0,
              speed: 0,
              curGun: 0,
              camMode: 0,
              gunTheta: 0,
              gunThetav: 0,
              powerups: [
                {
                  name: 'speedBoost',
                  val: 1,
                  timer: 0,
                  duration: 5
                },
                {
                  name: 'guns++',
                  val: 1,
                  timer: 0,
                  duration: 20
                }
              ],
              shotTimer: 0,
              forward: true,
              shooting: false,
              shotInterval: 1,
              grounded: false,
              powerupTimer: 0,
              poweredUp: false,
              keys: Array(256).fill(),
              decon: JSON.parse(JSON.stringify(base_car_decon)),
              distanceTravelled: 0
            }
            return car
          }
          
          async function masterInit(){
            powerupTemplate = [
              {
                name: 'speedBoost',
                val: 1,
                duration: 5
              },
              {
                name: 'guns++',
                val: 1,
                duration: 20
              }
            ]
            cams = []
            grav = .66
            iCarsc = 1
            sparks = []
            camDist = 7
            flashes = []
            bullets = []
            iSparkv = .4
            iBulletv = 16
            maxSpeed = 40
            powerups = []
            carTrails = []
            showDash = true
            showCars = true
            camSelected = 0
            maxCamDist = 25
            crosshairSel = 0
            showGyro = false
            smokeTrails = []
            powerupFreq = 500
            showstars = true
            mapChoice= 'topo'
            showFloor = true
            camModeStyles = 2
            camFollowSpeed = 2
            maxTurnRadius = .1
            showCrosshair = true
            keyTimerInterval = 1/60*10 // .5 sec
            keyTimers = Array(256).fill(0)
            base_gun = Cylinder(1,8,.6,1.5).map(v=>{
              v.map(q=>{
                X = q[0]
                Y = q[1]
                Z = q[2]
                R3(0,Math.PI/2,0)
                q[0] = X
                q[1] = Y
                q[2] = Z
              })
              return v
            })
            base_car = await loadOBJ('car_no_wheels.obj', 1, 0, 0, 0, 0, 0, Math.PI)
            base_wheel = await loadOBJ('car_wheel.obj', 1, 0, 0, 0, 0, 0, Math.PI)
            base_car_lowpoly = await loadOBJ('car_no_wheels_lowpoly.obj', 1, 0, -1, -1.5, 0, 0, Math.PI)
            base_wheel_lowpoly = await loadOBJ('car_wheel_lowpoly.obj', 1, 0, 0, 0, 0, 0, Math.PI)
            base_car_decon = JSON.parse(JSON.stringify(base_car)).map(v=>{
              v = [0, 0, 0,  // X,   Y,   Z
                   0, 0, 0,  // vx,  vy,  vz
                   0, 0, 0,  // rl,  pt,  yw
                   0, 0, 0,  // rlv, ptv, ywv
                   ] 
              return v
            })
          }
          await masterInit()
          
          spawnCam = car => {
            
            X = car.X
            Z = car.Z - camDist
            Y = floor(X, Z) - 10
            R(0, 0, 0)
            return {
              X, Y, Z
            }
          }
          
          cars = Array(iCarsc).fill().map(v => {
            X = 0, Z = 0
            Y = floor(X, Z)
            let car = spawnCar(X,Y,Z) 
            car.cam = spawnCam(car)
            return car
          })
            
          oX=0, oY=0, oZ=30
          Rl=0, Pt=-.125, Yw=0
          
          
          c.onkeydown = e => {
            e.preventDefault()
            e.stopPropagation()
            cars[0].keys[e.keyCode] = true
          }

          c.onkeyup = e => {
            e.preventDefault()
            e.stopPropagation()
            cars[0].keys[e.keyCode] = false
          }
          
          doKeys = () => {
            curCar = cars[camSelected]
            curCar.shooting = false
            cars[0].keys.map((v,i) => {
              if(v){
                switch(i){
                  case  84:
                    if(keyTimers[i] < t){
                      keyTimers[i] = t+keyTimerInterval
                      showDash = !showDash
                    }
                  break
                  case  67:
                    if(keyTimers[i] < t){
                      keyTimers[i] = t+keyTimerInterval
                      if(showCrosshair && crosshairSel<crosshairImgs.length-1){
                        crosshairSel++
                      }else{
                        crosshairSel=0
                        showCrosshair = !showCrosshair
                      }
                    }
                  break
                  case 48:
                    if(camSelected == 0 && keyTimers[i] < t){
                      keyTimers[i] = t+keyTimerInterval
                      curCar.camMode++
                      curCar.camMode %= camModeStyles
                    }else{
                      camSelected = 0
                    }
                    break
                  case 65:
                    if(curCar.grounded){
                      d1 = Math.hypot(curCar.vx,curCar.vz)
                      curCar.ywv -= .04
                      curCar.ywv = Math.min(maxTurnRadius, Math.max(-maxTurnRadius, curCar.ywv))
                    }
                    break
                  case 37:
                    if(curCar.grounded){
                      d1 = Math.hypot(curCar.vx,curCar.vz)
                      curCar.ywv -= .04
                      curCar.ywv = Math.min(maxTurnRadius, Math.max(-maxTurnRadius, curCar.ywv))
                    }
                    break
                  case 87:
                    if(curCar.grounded){
                      let boost = curCar.powerups.filter(powerup=>powerup.name=='speedBoost')[0].val
                      curCar.vx += S(curCar.yw) * .08 * boost
                      curCar.vz += C(curCar.yw) * .08 * boost
                      d1 = Math.hypot(curCar.vx,curCar.vy,curCar.vz)
                      d2 = Math.min(maxSpeed, d1)
                      curCar.vx /=d1
                      curCar.vz /=d1
                      curCar.vx *=d2
                      curCar.vz *=d2
                    }
                    break
                  case 38:
                    if(curCar.grounded){
                      let boost = curCar.powerups.filter(powerup=>powerup.name=='speedBoost')[0].val
                      curCar.vx += S(curCar.yw) * .08 * boost
                      curCar.vz += C(curCar.yw) * .08 * boost
                      d1 = Math.hypot(curCar.vx,curCar.vy,curCar.vz)
                      d2 = Math.min(maxSpeed, d1)
                      curCar.vx /=d1
                      curCar.vz /=d1
                      curCar.vx *=d2
                      curCar.vz *=d2
                    }
                    break
                  case 68:
                    if(curCar.grounded){
                      d1 = Math.hypot(curCar.vx,curCar.vz)
                      curCar.ywv += .04
                      curCar.ywv = Math.min(maxTurnRadius, Math.max(-maxTurnRadius, curCar.ywv))
                    }
                    break
                  case 39:
                    if(curCar.grounded){
                      d1 = Math.hypot(curCar.vx,curCar.vz)
                      curCar.ywv += .04
                      curCar.ywv = Math.min(maxTurnRadius, Math.max(-maxTurnRadius, curCar.ywv))
                    }
                    break
                  case 83:
                    if(curCar.grounded){
                      let boost = curCar.powerups.filter(powerup=>powerup.name=='speedBoost')[0].val
                      curCar.vx -= S(curCar.yw) * .04 * boost
                      curCar.vz -= C(curCar.yw) * .04 * boost
                      d1 = Math.hypot(curCar.vx,curCar.vy,curCar.vz)
                      d2 = Math.min(maxSpeed, d1)
                      curCar.vx /=d1
                      curCar.vz /=d1
                      curCar.vx *=d2
                      curCar.vz *=d2
                    }
                    break
                  case 40:
                    if(curCar.grounded){
                      let boost = curCar.powerups.filter(powerup=>powerup.name=='speedBoost')[0].val
                      curCar.vx -= S(curCar.yw) * .04 * boost
                      curCar.vz -= C(curCar.yw) * .04 * boost
                      d1 = Math.hypot(curCar.vx,curCar.vy,curCar.vz)
                      d2 = Math.min(maxSpeed, d1)
                      curCar.vx /=d1
                      curCar.vz /=d1
                      curCar.vx *=d2
                      curCar.vz *=d2
                    }
                    break
                  case 17:
                    curCar.shooting = true
                    shoot(curCar)
                    break
                }
              }
            })
          }
          window.onload = () => {c.focus()}
          
          spawnBullet = car => {
            floatingCam = !car.camMode
            sd = curCar.curGun
            ls = car.curGun > 1 ? 1 : 0
            for(let i=sd; i--;){
              px = S(p=Math.PI*2/sd*i+car.gunTheta)
              py = C(p)
              X = px/2
              Y = py/2
              Z = iBulletv
              if(floatingCam){
                R3(car.rl, car.pt, car.yw)
              }else{
                R3(curCar.rl/1.5, curCar.pt/1.25-.03, curCar.yw)
              }
              vx = X + car.vx
              vy = Y
              vz = Z + car.vz
              X = px*ls
              Y = py*ls - (floatingCam ? 3 : 3.5)
              Z = 4
              if(floatingCam){
                carFunc(car)
              }else{
                R3(car.rl,car.pt,car.yw)
              }
              X += car.X + (floatingCam ? car.vx : 0)
              Y += car.Y
              Z += car.Z + (floatingCam ? car.vz : 0)
              spawnFlash(X, Y, Z, .025)
              bullets = [...bullets, [X, Y-(floatingCam?0:.1), Z, vx, vy, vz, 1]]
            }
          }
          
          shoot = car => {
            if(car.shotTimer<t){
              car.shotTimer = t + 1/60*car.shotInterval
              spawnBullet(car)
            }
          }
          
          carFunc = car =>{
            Y+=2
            Z+=2
            R3(car.rl/1.5, car.pt/1.25, car.yw)
            //R3(car.rl, car.pt, car.yw)
            Y-=2
            Z-=2
          }
          
          spawnFlash = (X, Y, Z, size = 1) => {
            for(let m = 1; m--;){
              flashes = [...flashes, [X,Y,Z,size]]
            }
          }
          
          spawnSparks = (X, Y, Z, intensity) => {
            intensity = Math.min(20,intensity)
            for(let m = 20 + intensity*4|0; m--;){
              let p1 = Rn()*Math.PI*2
              let p2 = Rn()<.5 ? Math.PI - Rn()**.5*Math.PI/2: Rn()**.5*Math.PI/2
              let pv = .05+Rn()**.5*(iSparkv+intensity/200 - .05)
              vx = S(p1) * S(p2) * pv
              vy = -Math.abs(C(p2) * pv*1.5)
              vz = C(p1) * S(p2) * pv
              sparks = [...sparks, [X,Y,Z,vx,vy,vz,1+intensity/10]]
            }
          }
          
          spawnPowerup = () => {
            let type
            cars.map(car => {
              ls = 10 + Rn()**.5*490
              X = car.X + S(p=Math.PI*2*Rn()) * ls
              Z = car.Z + C(p) * ls
              Y = floor(X, Z) - 3
              type = (Rn()**2*powerupTemplate.length)|0
              initVal = powerupTemplate[type].val
              duration = powerupTemplate[type].duration
              nm = powerupTemplate[type].name
              powerups = [...powerups, [X,Y,Z,0,0,0,type,initVal,nm,duration]]
            })
          }
          
          drawCar = (car, idx, col1='#0f83', col2="") => {
            
            while(car.yw > Math.PI*4) car.yw-=Math.PI*8
            while(car.yw < -Math.PI*4) car.yw+=Math.PI*8
            while(car.pt > Math.PI*4) car.pt-=Math.PI*8
            while(car.pt < -Math.PI*4) car.pt+=Math.PI*8
            while(car.rl > Math.PI*4) car.rl-=Math.PI*8
            while(car.rl < -Math.PI*4) car.rl+=Math.PI*8
            
            let ox = car.X
            let oy = car.Y
            let oz = car.Z
            
            fl = floor(car.X, car.Z)
            ocg = car.grounded
            car.grounded = car.Y >= fl - 1
            car.vy /= 1.01
            car.X += car.vx
            car.Y += car.vy += grav
            car.Z += car.vz
            
            X=Y=0, Z = 1
            R3(0,0,car.yw)
            X1 = X, Y1 = Y, Z1 = Z
            X=Y=0, Z = -1
            R3(0,0,car.yw)
            X2 = X, Y2 = Y, Z2 = Z
            X3 = car.vx
            Z3 = car.vz
            d1 = Math.hypot(X3-X1,Z3-Z1)
            d2 = Math.hypot(X3-X2,Z3-Z2)
            car.forward = d2>=d1-.1
            
            d1 = Math.hypot(car.vx,car.vz)
            car.speed = d1
            car.distanceTravelled += d1 * (car.forward? 1 : -1)
            dx=dy=dz=0
            car.rl += car.rlv
            car.pt += car.ptv
            if(car.grounded) car.yw += car.ywv * 24 *  Math.min(.04, d1/maxSpeed/2) * (cars.keys[40] ? -1 : 1) * (car.keys[40] || car.keys[83] ? -1 : 1)
            car.rlv /= 1.005
            car.ptv /= 1.005
            car.ywv /= 1.005
            sparkWheels = false
            if(car.grounded){
              if(!ocg && car.vy>1){
                intensity = car.vy*5
                sparkWheels = true
                if(car.vy > 6){
                  car.curGun = 0
                  car.decon.map(v=>{
                    v[3] += (Rn() - .5) * intensity /4
                    v[4] += (Rn() - .5) * intensity /4
                    v[5] += (Rn() - .5) * intensity /4
                    v[6] += (Rn() - .5) * intensity /4
                    v[7] += (Rn() - .5) * intensity /4
                    v[8] += (Rn() - .5) * intensity /4
                  })
                }
                car.vy*=-.5
              }else{
                car.vy /= 1.5
              }
              if(!car.keys[38] && !car.keys[40]){
                car.vx /= 1.06
                car.vz /= 1.06
              }else{
                car.vx /= 1.015
                car.vz /= 1.015
              }
              car.rlv /= 1.25
              car.ptv /= 1.25
              car.ywv /= 1.25
            }else{
              car.rl += car.rlv/1.4
              car.pt += car.ptv/1.4
              car.yw += car.ywv/1.4
            }

            fl = floor(car.X, car.Z)
            car.Y = Math.min(fl, car.Y)
            
            dy = Math.min(0, (car.Y - oy)/2) / (1+Math.abs(fl-car.Y))
            car.vy += Math.max(-5, dy*2)
            
            let carx = car.X
            let cary = car.Y
            let carz = car.Z
            

            if(car.grounded){
              X = -4
              Y = 0
              Z = 0
              R3(0, 0, car.yw)
              floor1 = floor(X+carx, Z+carz)
              X = 4
              Y = 0
              Z = 0
              R3(0, 0, car.yw)
              floor2 = floor(X+carx, Z+carz)

              X = 0
              Y = 0
              Z = -8
              R3(0, 0, car.yw)
              floor3 = floor(X+carx, Z+carz)
              X = 0
              Y = 0
              Z = 8
              R3(0, 0, car.yw)
              floor4 = floor(X+carx, Z+carz)
              car.ptv += Math.min(.1,Math.max(-.1,((floor4-floor3)/16-car.pt)/8))
              car.rlv += Math.min(.1,Math.max(-.1,((floor1-floor2)/8-car.rl)/8))
            }

            if(car.camMode && idx == 0){
              olc = x.lineCap
              x.lineJoin = x.lineCap = 'butt';
              (idx && Math.hypot(car.X-cars[0].X,car.Y-cars[0].Y,car.Z-cars[0].Z)>50 ? base_car_lowpoly : base_car_lowpoly).map((v, i) => {
                x.beginPath()
                ax=ay=az = 0
                v.map((q, j) => {
                  ax += q[0]
                  ay += q[1]
                  az += q[2]
                })
                ax /= v.length
                ay /= v.length
                az /= v.length
                
                v.map((q, j) => {
                  for(m=12;m--;)car.decon[i][m]/=1.1
                  dconx = (car.decon[i][0] += car.decon[i][3])
                  dcony = (car.decon[i][1] += car.decon[i][4])
                  dconz = (car.decon[i][2] += car.decon[i][5])
                  X = q[0] -ax
                  Y = q[1] -ay
                  Z = q[2] -az
                  R3(car.decon[i][6] += car.decon[i][9], car.decon[i][7] += car.decon[i][10], car.decon[i][8] += car.decon[i][11])
                  X += 0 + dconx + ax
                  Y += 3.5 + dcony + ay
                  Z += 4 + dconz + az
                  X*=2
                  l = Q2()
                  if(Z>4.5 && l[1]>c.height/3 && i>80) x.lineTo(...l)
                })
                alpha = (l[1]/c.height/2)**4*5
                if(alpha > .05) stroke(col1,col2,3,true,alpha)
              })
              
              for(n=4; n--;){
                if(sparkWheels){
                  X = (n%2?1.5:-1.5)
                  Y = 1
                  Z = ((n/2|0)?3.8:-3.8)-1.2
                  spawnSparks(car.X+X,car.Y+Y,car.Z+Z,intensity)
                };
                (idx && Math.hypot(car.X-cars[0].X,car.Y-cars[0].Y,car.Z-cars[0].Z)>30 ? base_wheel_lowpoly : base_wheel).map((v, i) => {
                  if((!car.forward && car.keys[38] || car.forward && car.keys[40])&& Rn()<.1){
                    let poly = JSON.parse(JSON.stringify(v)).map(q => {
                      X = q[0]
                      Y = q[1]
                      Z = q[2]
                      X += (n%2?2.5:-2.5)
                      Y -= 1.1
                      Z += ((n/2|0)?3.8:-3.8)-3
                      carFunc(car)
                      q[0] = X*2
                      q[1] = Y
                      q[2] = Z
                      q[3] = car.vx/2
                      q[4] = 0
                      q[5] = car.vz/2
                      q[6] = 1
                      q[7] = car.X
                      q[8] = car.Y
                      q[9] = car.Z
                      return q
                    })
                    smokeTrails = [...smokeTrails, poly]
                  }
                  x.beginPath()
                  v.map((q, j) => {
                    dconx = (car.decon[i][0] += car.decon[i][3])
                    dcony = (car.decon[i][1] += car.decon[i][4])
                    dconz = (car.decon[i][2] += car.decon[i][5])
                    X = q[0] //-ax
                    Y = q[1] //-ay
                    Z = q[2] //-az
                    R3(car.decon[i][6] += car.decon[i][9], car.decon[i][7] += car.decon[i][10], car.decon[i][8] += car.decon[i][11])
                    X = q[0] + dconx
                    Y = q[1]+1.1 + dcony
                    Z = q[2] + dconz
                    if(!(n%2)) R3(0,0,Math.PI)
                    R3(0,car.distanceTravelled,0)
                    if(n/2|0) R3(0,0,car.ywv*8)
                    X += (n%2?2.5:-2.5)
                    Y -= 1.1
                    Z += ((n/2|0)?3.8:-3.8)-1.2
                    X *= 2
                    Y += 3.5
                    Z += 4
                    l = Q2()
                    if(Z>1) x.lineTo(...l)
                  })
                  alpha = (l[1]/c.height/2)**4*10
                  stroke('#0005','#f043',1,false,alpha)
                })
              }
              x.lineJoin = x.lineCap = olc
              
              if(showCrosshair){
                x.globalAlpha = .2
                s=800
                x.drawImage(crosshairImgs[crosshairSel].img,c.width/2-s/2,c.height/2-s/2,s,s)
                x.globalAlpha = 1
                x.lineJoin = x.lineCap = olc
                //x.lineCap = x.lineJoin = 'round'
              }
              
              //guns
              sd = car.curGun
              ls = car.curGun>1 ? 1 : 0
              for(let i = sd; i--;){
                tx = S(p=Math.PI*2/sd*i+car.gunTheta)*ls
                ty = C(p)*ls
                tz = 0
                car.gunThetav+=car.shooting?.02:0
                car.gunTheta += car.gunThetav
                car.gunThetav /=1.25
                base_gun.map((v,i) => {
                  x.beginPath()
                  v.map((q, j) => {
                    X = q[0]
                    Y = q[1]
                    Z = q[2]
                    R3(car.gunTheta,0,0)
                    X += tx
                    Y += ty
                    Z += tz + 3
                    //R3(car.rl,car.pt,car.yw)
                    //X += car.X
                    //Y += car.Y
                    //Z += car.Z
                    //R(Rl,Pt,Yw,1)
                    if(Z>0)x.lineTo(...Q2())
                  })
                  stroke('#4f81','',1,false)
                })
              }
              x.lineCap = x.lineJoin = 'butt'
            }else{
              x.lineJoin = x.lineCap = 'butt';
              (idx && Math.hypot(car.X-cars[0].X,car.Y-cars[0].Y,car.Z-cars[0].Z)>50 ? base_car_lowpoly : base_car).map((v, i) => {
                ax=ay=az = 0
                v.map((q, j) => {
                  ax += q[0]
                  ay += q[1]
                  az += q[2]
                })
                ax /= v.length
                ay /= v.length
                az /= v.length
                if(car.poweredUp && Rn()<.05){
                  let poly = JSON.parse(JSON.stringify(v)).map(q => {
                    X = q[0]
                    Y = q[1]
                    Z = q[2]
                    carFunc(car)
                    q[0] = X
                    q[1] = Y
                    q[2] = Z
                    q[3] = car.vx/1.25
                    q[4] = 0
                    q[5] = car.vz/1.25
                    q[6] = 1
                    q[7] = car.X
                    q[8] = car.Y
                    q[9] = car.Z
                    return q
                  })
                  carTrails = [...carTrails, poly]
                }
                
                x.beginPath()
                v.map((q, j) => {
                  for(m=12;m--;)car.decon[i][m]/=1.1
                  d = Math.hypot(car.decon[i][0],car.decon[i][0],car.decon[i][0])
                  dconx = (car.decon[i][0] += car.decon[i][3])
                  dcony = (car.decon[i][1] += car.decon[i][4]+=(d>.1?grav/3:0))
                  dconz = (car.decon[i][2] += car.decon[i][5])
                  if(dcony + cary + ay >= (f=floor(carx+ax+dconx, carz+az+dconz))){
                    car.decon[i][4] = (car.decon[i][4]>0 ? -car.decon[i][4] : car.decon[i][4]) * .7
                    dcony = car.decon[i][1] += car.decon[i][4]
                  }
                  X = q[0] -ax
                  Y = q[1] -ay
                  Z = q[2] -az
                  R3(car.decon[i][6] += car.decon[i][9], car.decon[i][7] += car.decon[i][10], car.decon[i][8] += car.decon[i][11])
                  X += ax
                  Y += ay
                  Z += az
                  carFunc(car)
                  X += dconx
                  Y += dcony
                  Z += dconz
                  X += carx
                  Y += cary
                  Z += carz
                  R(Rl,Pt,Yw,1)
                  if(Z>0) x.lineTo(...Q())
                })
                stroke(col1,col2,3,false)
              })
              
              for(n=4; n--;){
                if(sparkWheels){
                  X = (n%2?1.5:-1.5)
                  Y = 1
                  Z = ((n/2|0)?3.8:-3.8)-1.2
                  spawnSparks(car.X+X,car.Y+Y,car.Z+Z,intensity)
                };
                ((idx && Math.hypot(car.X-cars[0].X,car.Y-cars[0].Y,car.Z-cars[0].Z)>50 ? base_wheel_lowpoly : base_wheel)).map((v, i) => {
                  if((!car.forward && car.keys[38] || car.forward && car.keys[40] )&& Rn()<.1){
                    let poly = JSON.parse(JSON.stringify(v)).map(q => {
                      X = q[0]
                      Y = q[1]
                      Z = q[2]
                      X += (n%2?2.5:-2.5)
                      Y -= 1.1
                      Z += ((n/2|0)?3.8:-3.8)-1.2
                      carFunc(car)
                      q[0] = X
                      q[1] = Y
                      q[2] = Z
                      q[3] = car.vx/2
                      q[4] = 0
                      q[5] = car.vz/2
                      q[6] = 1
                      q[7] = car.X
                      q[8] = car.Y
                      q[9] = car.Z
                      return q
                    })
                    smokeTrails = [...smokeTrails, poly]
                  }
                  
                  x.beginPath()
                  v.map((q, j) => {
                    dconx = (car.decon[i][0] += car.decon[i][3])
                    dcony = (car.decon[i][1] += car.decon[i][4])
                    dconz = (car.decon[i][2] += car.decon[i][5])
                    X = q[0] -ax
                    Y = q[1] -ay
                    Z = q[2] -az
                    R3(car.decon[i][6] += car.decon[i][9], car.decon[i][7] += car.decon[i][10], car.decon[i][8] += car.decon[i][11])
                    X = q[0] + dconx
                    Y = q[1]+1.1 + dcony
                    Z = q[2] + dconz
                    if(!(n%2)) R3(0,0,Math.PI)
                    R3(0,car.distanceTravelled,0)
                    if(n/2|0) R3(0,0,car.ywv*8)
                    X += (n%2?2.5:-2.5)
                    Y -= 1.1
                    Z += ((n/2|0)?3.8:-3.8)-1.2
                    carFunc(car)
                    X += carx
                    Y += cary
                    Z += carz
                    R(Rl,Pt,Yw,1)
                    if(Z>0) x.lineTo(...Q())
                  })
                  stroke('#0005','#f043',1,false)
                })
              }
              
              //guns
              //x.lineJoin = x.lineCap = 'round'
              sd = car.curGun
              ls = car.curGun>1 ? 1 : 0
              for(let i = sd; i--;){
                tx = S(p=Math.PI*2/sd*i+car.gunTheta)*ls
                ty = C(p)*ls
                tz = 0
                car.gunThetav+=car.shooting?.02:0
                car.gunTheta += car.gunThetav
                car.gunThetav /=1.25
                base_gun.map((v,i) => {
                  x.beginPath()
                  v.map((q, j) => {


                    X = q[0]
                    Y = q[1]
                    Z = q[2]
                    R3(car.gunTheta,0,0)
                    X += tx
                    Y += ty - 3
                    Z += tz + 3
                    carFunc(car)
                    X += car.X
                    Y += car.Y
                    Z += car.Z
                    R(Rl,Pt,Yw,1)
                    if(Z>0)x.lineTo(...Q())
                  })
                  stroke('#4f86','',4,false)
                })
              }
              
              
              if(showGyro){
                x.beginPath()
                X = 0
                Y = -3
                Z = 0
                carFunc(car)
                X += car.X
                Y += car.Y
                Z += car.Z
                R(Rl,Pt,Yw,1)
                if(Z>0) x.lineTo(...Q())
                X = 0
                Y = -3
                Z = 5
                carFunc(car)
                X += car.X
                Y += car.Y
                Z += car.Z
                R(Rl,Pt,Yw,1)
                if(Z>0) x.lineTo(...Q())
                stroke('#f008', '', 5, true)

                x.beginPath()
                X = 0
                Y = -3
                Z = 0
                carFunc(car)
                X += car.X
                Y += car.Y
                Z += car.Z
                R(Rl,Pt,Yw,1)
                if(Z>0) x.lineTo(...Q())
                X = 5
                Y = -3
                Z = 0
                carFunc(car)
                X += car.X
                Y += car.Y
                Z += car.Z
                R(Rl,Pt,Yw,1)
                if(Z>0) x.lineTo(...Q())
                stroke('#f008', '', 5, true)

                x.beginPath()
                X = 0
                Y = -3
                Z = 0
                carFunc(car)
                X += car.X
                Y += car.Y
                Z += car.Z
                R(Rl,Pt,Yw,1)
                if(Z>0) x.lineTo(...Q())
                X = 0
                Y = -8
                Z = 0
                carFunc(car)
                X += car.X
                Y += car.Y
                Z += car.Z
                R(Rl,Pt,Yw,1)
                if(Z>0) x.lineTo(...Q())
                stroke('#f008', '', 5, true)
              }
            }
          }
        }

        curCar = cars[camSelected]
        switch(curCar.camMode){
          case 0:
            d = Math.hypot(curCar.vx, curCar.vz)
            cd = Math.min(maxCamDist, camDist + d/2)
            dx = curCar.cam.X - curCar.X
            dy = curCar.cam.Y - curCar.Y
            dz = curCar.cam.Z - curCar.Z
            d = Math.hypot(dx,dy,dz)
            nx = S(t/4)*cd
            nz = C(t/4)*cd
            X = dx/d*cd-nx + curCar.X
            Z = dz/d*cd-nz + curCar.Z
            Y = Math.min(floor(X,Z)-cd, dy/d*cd-cd/2  + curCar.Y)
            tgtx = X
            tgty = Y
            tgtz = Z
            curCar.cam.X -= (curCar.cam.X - tgtx)/camFollowSpeed
            curCar.cam.Y -= (curCar.cam.Y - tgty)/camFollowSpeed
            curCar.cam.Z -= (curCar.cam.Z - tgtz)/camFollowSpeed
            oX = curCar.cam.X
            oZ = curCar.cam.Z
            oY = curCar.cam.Y
            Pt = -Math.acos((oY-curCar.Y) / (Math.hypot(oX-curCar.X,oY-curCar.Y,oZ-curCar.Z)+.001))+Math.PI/2
            Yw = -Math.atan2(curCar.X-oX,curCar.Z-oZ)
            Rl = 0
            break
          case 1:
            X = 0
            Y = -5
            Z = 25
            R3(0,curCar.pt,0)
            R3(0,0,curCar.yw)
            X_ = X+=curCar.X
            Y_ = Y+=curCar.Y
            Z_ = Z+=curCar.Z
            X = 0
            Y = -3
            Z = 1
            R3(0,curCar.pt,0)
            R3(0,0,curCar.yw)
            oX = curCar.cam.X = curCar.X - X
            oY = curCar.cam.Y = curCar.Y - 3
            oZ = curCar.cam.Z = curCar.Z - Z
            Pt = -Math.acos((oY-Y_) / (Math.hypot(oX-X_,oY-Y_,oZ-Z_)+.001))+Math.PI/2
            Yw = -Math.atan2(X_-oX,Z_-oZ)
            Rl = -curCar.rl
            break
        }
        
        x.globalAlpha = 1
        x.fillStyle='#000C'
        x.fillRect(0,0,c.width,c.height)
        x.lineJoin = x.lineCap = 'butt'

        doKeys()
        if(!((t*60|0)%((powerupFreq/powerupTemplate.length)|0))) spawnPowerup()
        
        if(showstars) ST.map(v=>{
          X = v[0]
          Y = v[1]
          Z = v[2]
          R(Rl,Pt,Yw,1)
          if(Z>0){
            if((x.globalAlpha = Math.min(1,(Z/5e3)**2))>.1){
              s = Math.min(1e3, 4e5/Z)
              x.fillStyle = '#ffffff04'
              l = Q()
              x.fillRect(l[0]-s/2,l[1]-s/2,s,s)
              s/=5
              x.fillStyle = '#fffa'
              x.fillRect(l[0]-s/2,l[1]-s/2,s,s)
            }
          }
        })

        x.globalAlpha = 1
        
        if(showFloor){
          
          cars.map(car => {
            
            let carx = car.X
            let carz = car.Z
            let cary = car.Y

            if(showFloor){
              rw = 128
              cl = rw/3|0
              sp = 8
              ls = sp/3.5//.75**.5*sp/2
              Array(rw*cl).fill().map((v, i) => {
                if(!((i+(i/cl/5|0))%3)){
                  tx = ((i%cl)-cl/2+.5)*sp
                  ty = 0
                  tz = (((i/cl|0)%rw)-rw/2+.5)*sp * (.75**2/2)
                  while(carz-tz>rw*sp*(.75**2/2)/2){
                    tz+=rw*sp*(.75**2/2)
                  }
                  while(carz-tz<-rw*sp*(.75**2/2)/2){
                    tz-=rw*sp*(.75**2/2)
                  }
                  ct = 0
                  while(carx-tx>cl*sp/2 && ct<1e3){
                    tx+=cl*sp
                    ct++
                  }
                  ct = 0
                  while(carx-tx<-cl*sp/2 && ct<1e3){
                    tx-=cl*sp
                    ct++
                  }
                    
                  x.beginPath()
                  ay = 0
                  for(j=6;j--;){
                    X = tx + S(p=Math.PI*2/6*j+Math.PI/6) * ls + ((i/cl|0)%2?sp/2:0)
                    Z = tz + C(p) * ls
                    Y = ty + floor(X, Z)
                    ay += Y
                    R(Rl,Pt,Yw,1)
                    if(Z>0) x.lineTo(...Q())
                  }
                  d1 = Math.hypot(tx-carx,tz-carz)
                  if(d1<rw){
                    ay /= 6
                    alpha = 1 / (1+d1**8/1e15)
                    col1 = ''//`hsla(${ay*3},99%,50%,${.5}`
                    col2= `hsla(${ay*3+180},99%,50%,${.3}`
                    if(alpha>.1) stroke(col1, col2, 5, false, alpha)
                  }
                }
              })
            }
          })
        }
        x.globalAlpha = 1
        
        if(showCars) {
          cars.map((car, idx) => {
            car.powerups.map((powerup, idx) => {
              switch(idx){
                case 0:
                  if(powerup.timer){
                    car.poweredUp = true
                    col1 = `hsla(${t*15000},99%,50%,1)`
                    col2 = `hsla(${t*15000},99%,50%,.2)`
                    drawCar(car, idx, col1, col2)
                  }
                break
                case 1:
                  if(powerup.timer){
                    car.curGun++
                    powerup.timer = 0
                    powerup.val=0
                  }
                break
              }
              if(powerup.timer && powerup.timer <=t){
                powerup.timer = 0
                powerup.val = 1
                car.poweredUp = false
              }
            })
            if(!car.poweredUp){
              drawCar(car, idx)
            }
          })
        }
          
        x.globalAlpha = 1


        powerups = powerups.filter(v=>v[7]>0)
        powerups.map(v=>{
          let starIdx
          X = v[0]
          Z = v[2]
          Y = v[1] = floor(X,Z) - 3
          cars.map(car=>{
            X2 = car.X
            Y2 = car.Y
            Z2 = car.Z
            if(Math.hypot(X2-X,Y2-Y,Z2-Z)<25){
              spawnFlash(X,Y,Z)
              switch(v[6]){
                case 0:
                  car.powerups[v[6]].val++
                  car.powerups[v[6]].timer = t + v[9]
                  break
                case 1:
                  //car.powerups[v[6]].val++
                  car.powerups[v[6]].timer = t + v[9]
                  break
              }
              v[7]=0
            }
          })
          R(Rl,Pt,Yw,1)
          if(Z>0){
            s = Math.min(1e4, 8e4/Z)
            l = Q()
            switch(v[6]){
              case 0:  //speedBoost
                starIdx = 4
              break
              case 1:  //guns++
                starIdx = 1
              break
            }
            x.drawImage(starImgs[starIdx].img,l[0]-s/2/1.065, l[1]-s/2/1.065,s,s)
          }

          X = v[0]
          Z = v[2]
          Y = v[1] = floor(X,Z) - 3
          R(Rl,Pt,Yw,1)
          if(Z>0){
            s = Math.min(4e3, 2e4/Z)
            l = Q()
            x.drawImage(powerupImgs[v[6]].img,l[0]-s/2, l[1]-s/2-15000/Z,s,s)
            x.textAlign = 'center'
            x.font = (fs=20000/Z)+'px Courier Prime'
            x.fillStyle = '#fff'
            x.fillText((v[7]*100|0),l[0], l[1]-30000/Z,s,s)
          }
          v[7] -= .0025
        })

        carTrails = carTrails.filter(v => {
          v = v.filter(q=>q[6]>0)
          return !!v.length
        })
        carTrails.map(v=>{
          x.beginPath()
          v.map(q => {
            q[7] += q[3]/=1.01
            q[8] += q[4]/=1.01
            q[9] += q[5]/=1.01
            X = (q[0] *= 1.05) + q[7]
            Y = (q[1] *= 1.05) + q[8]
            Z = (q[2] *= 1.05) + q[9]
            R(Rl,Pt,Yw,1)
            if(Z>0) x.lineTo(...Q())
            a=q[6] -= .05
          })
          
          stroke('', '#f0f6',1,false,Math.max(0,a))
        })

        smokeTrails = smokeTrails.filter(v => {
          v = v.filter(q=>q[6]>0)
          return !!v.length
        })
        smokeTrails.map(v=>{
          x.beginPath()
          v.map(q => {
            q[7] += q[3]/=1.01
            q[8] += q[4]/=1.01
            q[9] += q[5]/=1.01
            X = (q[0] *= 1.05) + q[7]
            Y = (q[1] *= 1.05) + q[8]
            Z = (q[2] *= 1.05) + q[9]
            R(Rl,Pt,Yw,1)
            if(Z>0) x.lineTo(...Q())
            a=q[6] -= .025
          })
          stroke('', '#6666',1,false,Math.max(0, a))
        })

        bullets = bullets.filter(v=>v[6]>0)
        bullets.map(v => {
          X = v[0] += v[3]
          Y = v[1] += v[4]
          Z = v[2] += v[5]
          R(Rl,Pt,Yw,1)
          if(Z>0){
            l = curCar.camMode?Q2():Q()
            s = Math.min(1e5,2e4/Z*v[6])
            x.drawImage(burst,l[0]-s/2,l[1]-s/2,s,s)
            //s/=2
            //x.drawImage(starImgs[4].img,l[0]-s/2/1.05,l[1]-s/2/1.05,s,s)
          }
          v[6] -= .025
        })

        flashes = flashes.filter(v=>v[3]>0)
        flashes.map(v=>{
          X = v[0]
          Y = v[1]
          Z = v[2]
          R(Rl,Pt,Yw,1)
          if(Z>0){
            l = curCar.camMode?Q2():Q()
            s = Math.min(1e5,5e5/Z*v[3])
            x.drawImage(starImgs[5].img,l[0]-s/2/1.05,l[1]-s/2/1.05,s,s)
          }
          v[3] -= .1
        })

        sparks = sparks.filter(v=>v[6]>0)
        sparks.map(v=>{
          X = v[0] += v[3]
          Y = v[1] += v[4]
          Z = v[2] += v[5]
          R(Rl,Pt,Yw,1)
          if(Z>0){
            l = Q()
            s = Math.min(1e4,600/Z*v[6])
            x.fillStyle = '#ff000006'
            x.fillRect(l[0]-s/2,l[1]-s/2,s,s)
            s/=3
            x.fillStyle = '#ff880010'
            x.fillRect(l[0]-s/2,l[1]-s/2,s,s)
            s/=3
            x.fillStyle = '#ffffffff'
            x.fillRect(l[0]-s/2,l[1]-s/2,s,s)
          }
          v[6]-=.1
        })
        
        x.globalAlpha = 1

        if(showDash){
          
          olc = x.lineJoin
          x.lineJoin = x.lineCap = 'butt'
          ls     = 200
          margin = 55

          switch(mapChoice){
            case 'topo':
              x.lineJoin = x.lineCap = 'round'
              let mapRes = 50
              let sp = 8
              let scl = 3, fl
              x.font = (fs=60) + 'px Courier Prime'
              x.textAlign = 'left'
              x.fillStyle = '#444'
              x.fillText('◄ ►', c.width - margin*4 - mapRes*sp, fs)
              x.fillStyle = '#fff'
              x.textAlign = 'right'
              x.fillText('MAP: TOPO', c.width - margin, fs)
              if(1)for(i=mapRes**2;i--;){
                X = ((i%mapRes)-mapRes/2+.5)*sp
                Y = ((i/mapRes|0)-mapRes/2+.5)*sp
                if(Math.hypot(X,Y)<ls*1.25){
                  worldX =  X * scl
                  worldZ =  Y * scl
                  tx = X, ty = Y, tz = Z
                  X = worldX
                  Y = 0
                  Z = worldZ
                  R3(0,0,-curCar.yw)
                  worldX = X + curCar.X
                  worldZ = Z - curCar.Z
                  X = tx, Y = ty, Z = tz
                  s = sp*1.3
                  fl = floor(worldX, -worldZ)
                  x.fillStyle = `hsla(${fl*3+180},99%,50%,.5)`
                  x.fillRect(c.width - margin/2 - mapRes*sp/2 + X - s/2, margin*1.66 + mapRes*sp/2 + Y - s/2, s, s)
                }
              }
              powerups.map(v=>{
                X = (v[0] - curCar.X)/scl
                Z = (v[2] - curCar.Z)/scl
                if(Math.hypot(X,Z)<ls*1.25){
                  Y = 0
                  R3(0,0,-curCar.yw)
                  s = sp*1.3*4
                  x.drawImage(powerupImgs[v[6]].img,c.width - margin/2 - mapRes*sp/2 + X - s/2, margin*1.66 + mapRes*sp/2 - Z - s/2, s, s)
                }
              })
              
              ls/=2
              s=250
              x.beginPath()
              let p_ = 0//curCar.yw
              X = c.width - margin/2 - mapRes*sp/2+ S(-p_)*ls/5
              Y = margin*1.66 + mapRes*sp/2 + C(-p_)*ls/5
              x.lineTo(X,Y)
              X = c.width - margin/2 - mapRes*sp/2
              Y = margin*1.66 + mapRes*sp/2
              x.lineTo(X,Y)
              tx = X += S(p=-p_+Math.PI)* ls/5
              ty = Y += C(p)* ls/5
              x.lineTo(X,Y)
              X += S(p+Math.PI/1.3)*ls/8
              Y += C(p+Math.PI/1.3)*ls/8
              x.lineTo(X,Y)
              x.lineTo(X=tx,Y=ty)
              X += S(p-Math.PI/1.3)*ls/8
              Y += C(p-Math.PI/1.3)*ls/8
              x.lineTo(X,Y)
              x.lineTo(tx,ty)
              Z=3
              stroke('#000','',2.5/2,false)

              stroke('#f00','',.5/2,true)
              //x.drawImage(starImgs[5].img,c.width - margin/2 - mapRes*sp/2 + 0 - s/2, margin*1.66 + mapRes*sp/2 + 0 - s/2, s, s)

              bullets.map(v=>{
                X = (v[0] - curCar.X)/scl
                Z = (v[2] - curCar.Z)/scl
                if(Math.hypot(X,Z)<ls*1.25){
                  Y = 0
                  R3(0,0,-curCar.yw)
                  s = sp*1.3*4
                  x.drawImage(starImgs[0].img,c.width - margin/2 - mapRes*sp/2 + X - s/2, margin*1.66 + mapRes*sp/2 - Z - s/2, s, s)
                }
              })

              x.lineJoin = x.lineCap = 'butt'
            break
            default:
            break
          }
          

          ls     = 200
          margin = 55
          
          //backlight
          x.beginPath()
          x.lineTo(-20,ls*2 + margin*3.25)
          x.lineTo(-20,-20)
          x.lineTo(c.width+20,-20)
          x.lineTo(c.width+20,Y_=ls*2+margin*3.25)
          x.lineTo(c.width - c.width/6,Y_=ls*2+margin*3.25)
          for(i=0;i<100;i++){
            X = c.width - c.width/6 - c.width*(2/3)/99*i
            Y = Y_ + (C(Math.PI/99*i)**4*ls-ls)*2.5
            x.lineTo(X,Y)
          }
          x.lineTo(-20,Y_=ls*2+margin*3.25)
          Z = 3
          col1 = curCar.forward ? '#0f82' : '#f002'
          col2 = curCar.forward ? '#0f82' : '#f042'
          stroke(col1, col2, 2)
          
          // speedometer
          margin += 15
          Z = 3
          col    = '#4ff'
          x.beginPath()
          x.arc(margin+ls,margin+ls,ls,0,7)
          stroke(col,'#4f82')
          sd     = 10
          opi    = -Math.PI*2/10
          x.textAlign = 'center'
          for(i=sd+1;i--;){
            x.font = (fs = 32) + 'px Courier Prime'
            x.fillStyle = '#fff'
            X = ls+margin+S(p=Math.PI*2/(sd+2)*-i+opi)*ls*1.2
            Y = ls+margin+C(p)*ls*1.2
            x.fillText(i*40,X,Y+fs/3)
          }
          sd     = 100
          for(i=sd+1;i--;){
            x.beginPath()
            f = !(i%10)?.75:(!(i%5)?.85:.95)
            X = ls+margin+S(p=Math.PI*2/(sd+20)*-i+opi)*(ls*f)
            Y = ls+margin+C(p)*(ls*f)
            x.lineTo(X,Y)
            X = ls+margin+S(p=Math.PI*2/(sd+20)*-i+opi)*ls
            Y = ls+margin+C(p)*ls
            x.lineTo(X,Y)
            Z=3
            stroke(col,'',.2,true)
          }
          x.beginPath()
          x.lineTo(margin+ls,margin+ls)
          X = ls+margin+S(p=Math.PI*2/(sd+2)*-(curCar.speed*Math.PI)+opi)*(ls*.8)
          Y = ls+margin+C(p)*(ls*.8)
          x.lineTo(X,Y)
          stroke('#f04','',2,true)
          margin -=15
          x.beginPath()
          x.lineTo(margin/2,ls*2+margin*2)
          x.lineTo(margin/2+ls/1.5,ls*2+margin*2)
          x.lineTo(margin/2+ls/1.5,ls*2+margin*3)
          x.lineTo(margin/2,ls*2+margin*3)
          Z=3
          x.textAlign = 'center'
          stroke(col,'#4f82',.2,true)
          x.fillStyle = '#fff'
          x.font = (fs = 60) + 'px Courier Prime'
          x.fillText((Math.round(curCar.speed*15)),margin*1.75,margin*3+ls*2-fs/6)
          x.textAlign = 'right'
          x.fillText('MPH ',margin+ls*1.5,margin*3+ls*2-fs/5)
          
          // reverse warning
          if(!curCar.forward && ((t*60|0)%6<3)){
            x.textAlign = 'center'
            x.font = (fs = 60) + 'px Courier Prime'
            x.fillStyle = '#f00'
            x.fillText('>>> REVERSE WARNING <<<', c.width/2-100, +fs/1.1)
          }else{
            x.textAlign = 'left'
            x.font = (fs = 50) + 'px Courier Prime'
            x.fillStyle = '#0f8'
            let bval = curCar.powerups[0].val
            x.fillText(`BOOST ${bval-1} ` + ('>'.repeat(bval-1)), c.width/2-300, fs/1.5)
            x.strokeStyle = '#4f82'
            x.lineWidth = 10
            x.strokeRect(c.width/2-300, fs-10,400,30)
            if(bval>1){
              x.fillStyle = '#f08'
              x.fillRect(c.width/2-300, fs-10,400 * (curCar.powerups[0].timer-t)/curCar.powerups[0].duration,30)
            }
          }
          x.lineJoin = x.lineCap = olc
        }

        t+=1/60
        requestAnimationFrame(Draw)
      }
      Draw()
    </script>
  </body>
</html>
FILE;

file_put_contents('../battleracer_practice/index.html', $file);

$file = <<<'FILE'
<?php
  function alphaToDec($val){
    $pow=0;
    $res=0;
    while($val!=""){
      $cur=$val[strlen($val)-1];
      $val=substr($val,0,strlen($val)-1);
      $mul=ord($cur)<58?$cur:ord($cur)-(ord($cur)>96?87:29);
      $res+=$mul*pow(62,$pow);
      $pow++;
    }
    return $res;
  }

  function decToAlpha($val){
    $alphabet="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $ret="";
    while($val){
      $r=floor($val/62);
      $frac=$val/62-$r;
      $ind=(int)round($frac*62);
      $ret=$alphabet[$ind].$ret;
      $val=$r;
    }
    return $ret==""?"0":$ret;
  }
  
  require_once('db.php');
  require_once('functions.php');
  $data = json_decode(file_get_contents('php://input'));
  $userName = mysqli_real_escape_string($link, $data->{'userName'});

  // ->maintenance
  // purge any player records that have not been updated in over 10 minutes
  for($i=2; $i--;){
    $table = '';
    switch($i){
      case 0: $table = 'battleracerSessions'; break;
      //case 1: $table = 'battleracerGames'; break;
    }
    if($table){
      $sql = "DELETE FROM $table WHERE TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP, date)) >= 600;";
      $res = mysqli_query($link, $sql);
    }
  }

  // purge any game records older than 1 day
  for($i=2; $i--;){
    $table = '';
    switch($i){
      //case 0: $table = 'battleracerSessions'; break;
      case 1: $table = 'battleracerGames'; break;
    }
    if($table){
      $sql = "DELETE FROM $table WHERE TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP, date)) >= 86400;";
      $res = mysqli_query($link, $sql);
    }
  }
  // /maintenance

  $success = false;
  
  $ct = 0;
  do{
    $gidx = 1e9 + (rand()%1e8);
    $sql = "SELECT id FROM battleracerGames WHERE id = $gidx";
    $res = mysqli_query($link, $sql);
    $good = mysqli_num_rows($res) == 0;
  }while(!$good && $ct<1e3);
  
  if($ct<1e3){
    $sanitizedName = mysqli_real_escape_string($link, $userName);
    $sql = "INSERT INTO battleracerSessions (name, data, gameID) VALUES(\"$sanitizedName\", \"[]\", $gidx)";
    mysqli_query($link, $sql);
    $userID = mysqli_insert_id($link);
    $data = mysqli_real_escape_string($link, newUserJSON($userName, $userID));
    $sql = "INSERT INTO battleracerGames (data, id) VALUES(\"$data\", $gidx)";
    mysqli_query($link, $sql);
    $success = true;
    $slug = decToAlpha($gidx);
    $msg = "created game for: $userName, with slug: $slug (id=$gidx)";
    echo json_encode([$success, $slug, $msg, $userID, $sql]);
  }else{
    echo json_encode([$success, 'fail', $sql]);
    die();
  }
?>
FILE;

file_put_contents('../battleracer/createGame.php', $file);

$file = <<<'FILE'
<?php
  require_once('db.php');

  function newUserJSON($userName, $userID, $data=[]){
    global $link;
    $sql = "SELECT unix_timestamp()";
    $res = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($res);
    $time = $row['unix_timestamp()'];
    $data['players'] = [];
    $data['players'][$userID] = [];
    $data['players'][$userID]['name'] = $userName;
    $data['players'][$userID]['time'] = $time;
    $data['collected'] = [];
    return json_encode($data);
  }
  function newUserJSON2($userName, $userID, $data=[]){
    global $link;
    $sql = "SELECT unix_timestamp()";
    $res = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($res);
    $time = $row['unix_timestamp()'];
    $data->{'players'}->{$userID} = [];
    $data->{'players'}->{$userID}['name'] = $userName;
    $data->{'players'}->{$userID}['time'] = $time;
    $data->{'collected'} = [];
    return json_encode($data);
  }
?>
FILE;

file_put_contents('../battleracer/functions.php', $file);

$file = <<<'FILE'
<!DOCTYPE html>
<html>
  <head>
    <style>
      /* latin-ext */
      @font-face {
        font-family: 'Courier Prime';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(u-450q2lgwslOqpF_6gQ8kELaw9pWt_-.woff2) format('woff2');
        unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
      }
      /* latin */
      @font-face {
        font-family: 'Courier Prime';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(u-450q2lgwslOqpF_6gQ8kELawFpWg.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
      }
      body,html{
        background: #000;
        margin: 0;
        height: 100vh;
        overflow: hidden;
      }
      #c{
        background:#000;
        display: block;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
      }
      #c:focus{
        outline: none;
      }
    </style>
  </head>
  <body>
    <canvas id="c" tabindex=0></canvas>
    <script>
      c = document.querySelector('#c')
      c.width = 1920
      c.height = 1080
      x = c.getContext('2d')
      C = Math.cos
      S = Math.sin
      t = 0
      T = Math.tan

      rsz=window.onresize=()=>{
        setTimeout(()=>{
          if(document.body.clientWidth > document.body.clientHeight*1.77777778){
            c.style.height = '100vh'
            setTimeout(()=>c.style.width = c.clientHeight*1.77777778+'px',0)
          }else{
            c.style.width = '100vw'
            setTimeout(()=>c.style.height =     c.clientWidth/1.77777778 + 'px',0)
          }
        },0)
      }
      rsz()

      async function Draw(){
        oX=oY=oZ=0
        if(!t){
          HSVFromRGB = (R, G, B) => {
            let R_=R/256
            let G_=G/256
            let B_=B/256
            let Cmin = Math.min(R_,G_,B_)
            let Cmax = Math.max(R_,G_,B_)
            let val = Cmax //(Cmax+Cmin) / 2
            let g = Cmax-Cmin
            let sat = Cmax ? g / Cmax: 0
            let min=Math.min(R,G,B)
            let max=Math.max(R,G,B)
            let hue = 0
            if(g){
              if(R>=G && R>=B) hue = (G-B)/(max-min)
              if(G>=R && G>=B) hue = 2+(B-R)/(max-min)
              if(B>=G && B>=R) hue = 4+(R-G)/(max-min)
            }
            hue*=60
            while(hue<0) hue+=360;
            while(hue>=360) hue-=360;
            return [hue, sat, val]
          }

          RGBFromHSV = (H, S, V) => {
            while(H<0) H+=360;
            while(H>=360) H-=360;
            let C = V*S
            let X = C * (1-Math.abs((H/60)%2-1))
            let m = V-C
            let R_, G_, B_
            if(H>=0 && H < 60)    R_=C, G_=X, B_=0
            if(H>=60 && H < 120)  R_=X, G_=C, B_=0
            if(H>=120 && H < 180) R_=0, G_=C, B_=X
            if(H>=180 && H < 240) R_=0, G_=X, B_=C
            if(H>=240 && H < 300) R_=X, G_=0, B_=C
            if(H>=300 && H < 360) R_=C, G_=0, B_=X
            let R = (R_+m)*256
            let G = (G_+m)*256
            let B = (B_+m)*256
            return [R,G,B]
          }
          
          R=R2=(Rl,Pt,Yw,m)=>{
            M=Math
            A=M.atan2
            H=M.hypot
            X=S(p=A(X,Z)+Yw)*(d=H(X,Z))
            Z=C(p)*d
            Y=S(p=A(Y,Z)+Pt)*(d=H(Y,Z))
            Z=C(p)*d
            X=S(p=A(X,Y)+Rl)*(d=H(X,Y))
            Y=C(p)*d
            if(m){
              X+=oX
              Y+=oY
              Z+=oZ
            }
          }
          Q=()=>[c.width/2+X/Z*700,c.height/2+Y/Z*700]
          I=(A,B,M,D,E,F,G,H)=>(K=((G-E)*(B-F)-(H-F)*(A-E))/(J=(H-F)*(M-A)-(G-E)*(D-B)))>=0&&K<=1&&(L=((M-A)*(B-F)-(D-B)*(A-E))/J)>=0&&L<=1?[A+K*(M-A),B+K*(D-B)]:0
          
          Rn = Math.random
          
          stroke = (scol, fcol, lwo=1, od=true, oga=1) => {
            if(scol){
              //x.closePath()
              if(od) x.globalAlpha = .2*oga
              x.strokeStyle = scol
              x.lineWidth = Math.min(1000,100*lwo/Z)
              if(od) x.stroke()
              x.lineWidth /= 4
              x.globalAlpha = 1*oga
              x.stroke()
            }
            if(fcol){
              x.globalAlpha = 1*oga
              x.fillStyle = fcol
              x.fill()
            }
          }

          burst = new Image()
          burst.src = "g/burst.png"
          
          starsLoaded = false, starImgs = [{loaded: false}]
          starImgs = Array(9).fill().map((v,i) => {
            let a = {img: new Image(), loaded: false}
            a.img.onload = () => {
              a.loaded = true
              setTimeout(()=>{
                if(starImgs.filter(v=>v.loaded).length == 9) starsLoaded = true
              }, 0)
            }
            a.img.src = `g/star${i+1}.png`
            return a
          })
          
          splash = new Image()
          splash.src = 'splash.jpg'
          starfield = document.createElement('video')
          loaded = false
          starfield.oncanplay = () =>{
            starfield.play()
            loaded = true
          }
          starfield.loop = true
          starfield.muted = true
          starfield.src = 'https://srmcgann.github.io/orbs/compound-starfield.mp4'
          
          
          cursorPos = 0
          curInputLeft = curInputRight = ''
          mask = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-=_+`~\][|}{\'":;/.,?>< '
               
               
          begin = () => {
            if(userName.length && userName.split('').filter(v=>v.charCodeAt(0)!=32).join('').length){
              userName = userName.split('').filter((v,i)=>i<10).join('')
              let sendData = {
                userName
              }
              fetch('createGame.php',{
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                },
                body: JSON.stringify(sendData),
              }).then(res=>res.json()).then(data=>{
                console.log(data)
                if(data[0]){
                  location.href = `g/?g=${data[1]}&gmid=${data[3]}&p=${data[3]}`
                }else{
                  console.log('error! crap')
                }
              })
            }
          }
          
          mx = my = 0
          c.onmousemove = e => {
            e.preventDefault()
            e.stopPropagation()
            rect = c.getBoundingClientRect()
            mx = (e.pageX-rect.x)/c.clientWidth*c.width
            my = (e.pageY-rect.y)/c.clientHeight*c.height
          }
          
          cFocused = false
          c.onfocus = () => {
            cFocused = true
          }
          
          c.onblur = () => {
            cFocused = false
          }
          
          c.onmousedown = e => {
            c.focus()
            e.preventDefault()
            e.stopPropagation()
            if(e.button == 0){
              buttons.map(button=>{
                if(button.hover){
                  eval(button.callback + '()')
                }
              })
            }
          }
          
          c.onkeydown = e => {
            e.preventDefault()
            e.stopPropagation()
            switch (e.key){
              case 'Enter':
                if((curInputLeft + curInputRight) != ''){
                  begin()
                }
              break
              case 'Backspace':
                curInputLeft = curInputLeft.substr(0, curInputLeft.length-1)
              break
              case 'Delete':
                curInputRight = curInputRight.substr(1)
              break
              case 'ArrowLeft':
                curInputRight = curInputLeft.substr(curInputLeft.length-1) + curInputRight
                curInputLeft = curInputLeft.substr(0, curInputLeft.length-1)
              break
              case 'ArrowUp':
              break
              case 'ArrowRight':
                curInputLeft = curInputLeft + curInputRight.substr(0,1)
                curInputRight = curInputRight.substr(1)
              break
              case 'ArrowDown':
              break
              default:
                curInputLeft += mask.indexOf(l=e.key) !== -1 ? l : ''
              break 
            }
          }
          
          c.focus()
          
          //globals
          userName = ''
          
          
          renderButton = (callback, X, Y, w, h, caption) => {
            tx = X
            ty = Y
            x.fillStyle = '#0f8d'
            x.fillRect(tx,ty,w,h)
            x.strokeStyle = '#0f84'
            x.lineWidth = 10
            x.strokeRect(X1=tx, Y1=ty, w, h)
            x.font = (fs = 50) + "px Courier Prime"
            x.fillStyle = '#0f8e'
            x.fillStyle = '#042f'
            x.fillText(caption, tx + 20, ty+=fs)
            
            X2=X1+w
            Y2=Y1+h
            if(mx>X1 && mx<X2 && my>Y1 && my<Y2){
              if(buttonsLoaded){
                buttons[bct].hover = true
              }else{
                buttons=[...buttons, {callback,X1,Y1,X2,Y2,hover:true}]
              }
              c.style.cursor = 'pointer'
            }else{
              if(buttonsLoaded){
                buttons[bct].hover = false
              }else{
                buttons=[...buttons, {callback,X1,Y1,X2,Y2,hover:false}]
              }
            }
            bct++
          }
          
          renderInput = (textVar, X, Y, w, h, placeholder, caption) => {
            tx = X
            ty = Y
            let ofx
            x.fillStyle = '#112c'
            x.fillRect(tx,ty,w,h)
            x.strokeStyle = '#2fa4'
            x.lineWidth = 10
            x.strokeRect(tx, ty, w, h)
            let fs
            x.font = (fs = 50) + "px Courier Prime"
            x.fillStyle = '#0f8a'
            x.fillText(caption, tx, ty-fs/2, w, h)
            x.fillStyle = eval(`${textVar} ? '#fff' : '#888'`) 
            eval(`x.fillText(${textVar} ? ${textVar} : placeholder, tx + 20, ty+=fs)`)
            eval(`${textVar} = curInputLeft + curInputRight`)
            if(showcursor && ((t*60|0)%30)<15){
              ofx = x.measureText(curInputLeft).width
              x.beginPath()
              x.lineTo(tx + ofx + fs/2, ty-fs/1.25)
              x.lineTo(tx + ofx + fs/2, ty-fs/1.25+fs)
              Z = 1
              stroke('#f00','',.25,true)
            }
          }
          buttonsLoaded = false
          buttons = []
        }
        
        oX=0, oY=0, oZ=16
        Rl=S(t/8)/3, Pt=0, Yw=0
        
        x.globalAlpha = 1
        x.fillStyle='#000'
        x.fillRect(0,0,c.width,c.height)
        x.lineJoin = x.lineCap = 'round'
        
        x.globalAlpha = 1

        if(loaded){
          showcursor = cFocused
          bct = 0
          x.globalAlpha = .6
          x.drawImage(splash,0,0,c.width,c.height)
          x.globalAlpha = 1
          x.fillStyle = '#02040844'
          x.fillRect(0,0,c.width,c.height)
          x.globalAlpha = .2
          x.drawImage(starfield,0,0,c.width,c.height)
          x.globalAlpha = 1
          c.style.cursor = 'default'
          
          w = c.width -100
          h = c.height -75
          x.fillStyle = '#2084'
          x.fillRect(c.width/2-w/2,c.height/2-h/2,w,h)
          x.strokeStyle = '#40f4'
          x.lineWidth = 20
          x.strokeRect(c.width/2-w/2,c.height/2-h/2,w,h)
          
          x.font = (fs = 133) + 'px Courier Prime'
          x.fillStyle = '#8fca'
          x.textAlign = 'left'
          ofy = 0
          x.fillText('play BATTLERACER', fs, ofy + fs*1.25)
          x.fillText('online', fs+ 800, ofy + fs*1.25+fs/1.25)

          ofy += fs
          renderInput('userName', fs, ofy + fs*1.25, 800, 70, 'name', 'enter your name')
          
          ofy += fs
          renderButton('begin', fs, ofy + fs*1.25, 375, 70, 'create game')
          buttonsLoaded = true
        }

        t+=1/60
        requestAnimationFrame(Draw)
      }
      Draw()
    </script>
  </body>
</html>
FILE;

file_put_contents('../battleracer/index.php', $file);

$file = <<<'FILE'
<?php

  //ini_set('display_errors', 0);
  //ini_set('display_startup_errors', 0);
  error_reporting(0);
  //error_reporting(E_ERROR | E_PARSE);
  $db_pass  = 'passwordface';
  $port     = '3306';
  $db_host  = 'localhost';

  $db = $_GET['db'];
  $db_user = $_GET['user'];

  $link     = mysqli_connect($db_host,$db_user,$db_pass,$db,$port);

  $sql = 'SELECT * FROM battleracerSessions';
  $res = mysqli_query($link, $sql);
  echo json_encode([!!mysqli_num_rows($res)]);
?>
FILE;

file_put_contents('../battleracer/status.php', $file);

$file = <<<'FILE'
<!DOCTYPE html>
<html>
  <head>
    <title>BATTLERACER multiplayer/online ARENA</title>
    <style>
      /* latin-ext */
      @font-face {
        font-family: 'Courier Prime';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(u-450q2lgwslOqpF_6gQ8kELaw9pWt_-.woff2) format('woff2');
        unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
      }
      /* latin */
      @font-face {
        font-family: 'Courier Prime';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(u-450q2lgwslOqpF_6gQ8kELawFpWg.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
      }
      body,html{
        background: #000;
        margin: 0;
        color: #fff;
        height: 100vh;
        overflow: hidden;
        font-family: Courier Prime;
      }
      #c{
        background:#000;
        display: block;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
      }
      #c:focus{
        outline: none;
      }
      #regFrame{
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 1000;
        display: none;
      }
      #launchModal{
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 1000;
        display: none;
        padding: 50px;
      }
      #launchStatus{
        color: #0f8;
      }
      .buttons{
        border: none;
        border-radius: 5px;
        background: #4f88;
        color: #fff;
        padding: 3px;
        min-width: 200px;
        cursor: pointer;
        font-family: Courier Prime;
      }
      .copyButton{
        display: inline-block;
        width: 30px;
        height: 30px;
        background-image: url(clippy.png);
        cursor: pointer;
        z-index: 500;
        background-size: 90% 90%;
        left: calc(50% + 180px);
        background-position: center center;
        background-repeat: no-repeat;
        border: none;
        background-color: #8fcc;
        margin: 5px;
        border-radius: 5px;
        vertical-align: middle;
      }
      #copyConfirmation{
        display: none;
        position: absolute;
        width: 100vw;
        height: 100vh;
        top: 0;
        left: 0;
        background: #012d;
        color: #8ff;
        opacity: 1;
        text-shadow: 0 0 5px #fff;
        font-size: 46px;
        text-align: center;
        z-index: 1000;
      }
      #innerCopied{
        position: absolute;
        top: 50%;
        width: 100%;
        z-index: 1020;
        text-align: center;
        transform: translate(0, -50%) scale(2.0, 1);
      }
      .resultLink{
        text-decoration: none;
        color: #fff;
        background: #4f86;
        padding: 10px;
        display: inline-block;
      }
      #resultDiv{
        position: absolute;
        margin-top: 50px;
        left: 50%;
        transform: translate(-50%);
      }
    </style>
  </head>
  <body>
    <div id="copyConfirmation"><div id="innerCopied">COPIED!</div></div>
    <canvas id="c" tabindex=0></canvas>
    <iframe id="regFrame"></iframe>
    <div id="launchModal">
      GAME IS LIVE!<br><br>
      <div id="gameLink"></div>
      <br><br><br><br>
      ...awaiting players...<br>
      <div id="launchStatus"></div>
    </div>
    <script>
      /*  to do
      //   ✔ map rotate
      //   ✔ wheelie bug
      //   ✔ reverse turning (fix dir)
      //   ✔ reverse warning
      //   ✔ car deconstruct / reconstruct
      //   ✔ powerups
      //   ✔ car trails
      //   ✔ finish dashboard
      //   * player list / cam selection
      //   * configurable drift
      //   * menu
      //   * multiplayer / arena integration
      //
      //
      //
      //
      */

      c = document.querySelector('#c')
      c.width = 1920
      c.height = 1080
      x = c.getContext('2d')
      C = Math.cos
      S = Math.sin
      t = 0
      T = Math.tan

      rsz=window.onresize=()=>{
        setTimeout(()=>{
          if(document.body.clientWidth > document.body.clientHeight*1.77777778){
            c.style.height = '100vh'
            setTimeout(()=>c.style.width = c.clientHeight*1.77777778+'px',0)
          }else{
            c.style.width = '100vw'
            setTimeout(()=>c.style.height =     c.clientWidth/1.77777778 + 'px',0)
          }
        },0)
      }
      rsz()

      async function Draw(){
        oX=oY=oZ=0
        if(!t){
          HSVFromRGB = (R, G, B) => {
            let R_=R/256
            let G_=G/256
            let B_=B/256
            let Cmin = Math.min(R_,G_,B_)
            let Cmax = Math.max(R_,G_,B_)
            let val = Cmax //(Cmax+Cmin) / 2
            let delta = Cmax-Cmin
            let sat = Cmax ? delta / Cmax: 0
            let min=Math.min(R,G,B)
            let max=Math.max(R,G,B)
            let hue = 0
            if(delta){
              if(R>=G && R>=B) hue = (G-B)/(max-min)
              if(G>=R && G>=B) hue = 2+(B-R)/(max-min)
              if(B>=G && B>=R) hue = 4+(R-G)/(max-min)
            }
            hue*=60
            while(hue<0) hue+=360;
            while(hue>=360) hue-=360;
            return [hue, sat, val]
          }

          RGBFromHSV = (H, S, V) => {
            while(H<0) H+=360;
            while(H>=360) H-=360;
            let C = V*S
            let X = C * (1-Math.abs((H/60)%2-1))
            let m = V-C
            let R_, G_, B_
            if(H>=0 && H < 60)    R_=C, G_=X, B_=0
            if(H>=60 && H < 120)  R_=X, G_=C, B_=0
            if(H>=120 && H < 180) R_=0, G_=C, B_=X
            if(H>=180 && H < 240) R_=0, G_=X, B_=C
            if(H>=240 && H < 300) R_=X, G_=0, B_=C
            if(H>=300 && H < 360) R_=C, G_=0, B_=X
            let R = (R_+m)*256
            let G = (G_+m)*256
            let B = (B_+m)*256
            return [R,G,B]
          }

          R=R2=(Rl,Pt,Yw,m)=>{
            M=Math
            X-=oX
            Y-=oY
            Z-=oZ
            A=M.atan2
            H=M.hypot
            X=S(p=A(X,Z)+Yw)*(d=H(X,Z))
            Z=C(p)*d
            Y=S(p=A(Y,Z)+Pt)*(d=H(Y,Z))
            Z=C(p)*d
            X=S(p=A(X,Y)+Rl)*(d=H(X,Y))
            Y=C(p)*d
          }
          R3=(Rl,Pt,Yw,m)=>{
            M=Math
            A=M.atan2
            H=M.hypot
            X=S(p=A(X,Y)+Rl)*(d=H(X,Y))
            Y=C(p)*d
            Y=S(p=A(Y,Z)+Pt)*(d=H(Y,Z))
            Z=C(p)*d
            X=S(p=A(X,Z)+Yw)*(d=H(X,Z))
            Z=C(p)*d
          }
          Q=()=>[c.width/2+X/Z*700,c.height/2+Y/Z*700]
          Q2=()=>[c.width/2+X/Z*1200,c.height/2+Y/Z*1200]
          I=(A,B,M,D,E,F,G,H)=>(K=((G-E)*(B-F)-(H-F)*(A-E))/(J=(H-F)*(M-A)-(G-E)*(D-B)))>=0&&K<=1&&(L=((M-A)*(B-F)-(D-B)*(A-E))/J)>=0&&L<=1?[A+K*(M-A),B+K*(D-B)]:0

          Rn = Math.random
          async function loadOBJ(url, scale, tx, ty, tz, rl, pt, yw) {
            let res
            await fetch(url, res => res).then(data=>data.text()).then(data=>{
              a=[]
              data.split("\nv ").map(v=>{
                a=[...a, v.split("\n")[0]]
              })
              a=a.filter((v,i)=>i).map(v=>[...v.split(' ').map(n=>(+n.replace("\n", '')))])
              ax=ay=az=0
              a.map(v=>{
                v[1]*=-1
                ax+=v[0]
                ay+=v[1]
                az+=v[2]
              })
              ax/=a.length
              ay/=a.length
              az/=a.length
              a.map(v=>{
                X=(v[0]-ax)*scale
                Y=(v[1]-ay)*scale
                Z=(v[2]-az)*scale
                R2(rl,pt,yw,0)
                v[0]=X
                v[1]=Y
                v[2]=Z
              })
              maxY=-6e6
              a.map(v=>{
                if(v[1]>maxY)maxY=v[1]
              })
              a.map(v=>{
                v[1]-=maxY-oY
                v[0]+=tx
                v[1]+=ty
                v[2]+=tz
              })

              b=[]
              data.split("\nf ").map(v=>{
                b=[...b, v.split("\n")[0]]
              })
              b.shift()
              b=b.map(v=>v.split(' '))
              b=b.map(v=>{
                v=v.map(q=>{
                  return +q.split('/')[0]
                })
                v=v.filter(q=>q)
                return v
              })

              res=[]
              b.map(v=>{
                e=[]
                v.map(q=>{
                  e=[...e, a[q-1]]
                })
                e = e.filter(q=>q)
                res=[...res, e]
              })
            })
            return res
          }

          geoSphere = (mx, my, mz, iBc, size) => {
            let collapse=0
            let B=Array(iBc).fill().map(v=>{
              X = Rn()-.5
              Y = Rn()-.5
              Z = Rn()-.5
              return  [X,Y,Z]
            })
            for(let m=200;m--;){
              B.map((v,i)=>{
                X = v[0]
                Y = v[1]
                Z = v[2]
                B.map((q,j)=>{
                  if(j!=i){
                    X2=q[0]
                    Y2=q[1]
                    Z2=q[2]
                    d=1+(Math.hypot(X-X2,Y-Y2,Z-Z2)*(3+iBc/40)*3)**4
                    X+=(X-X2)*99/d
                    Y+=(Y-Y2)*99/d
                    Z+=(Z-Z2)*99/d
                  }
                })
                d=Math.hypot(X,Y,Z)
                v[0]=X/d
                v[1]=Y/d
                v[2]=Z/d
                if(collapse){
                  d=25+Math.hypot(X,Y,Z)
                  v[0]=(X-X/d)/1.1
                  v[1]=(Y-Y/d)/1.1         
                  v[2]=(Z-Z/d)/1.1
                }
              })
            }
            mind = 6e6
            B.map((v,i)=>{
              X1 = v[0]
              Y1 = v[1]
              Z1 = v[2]
              B.map((q,j)=>{
                X2 = q[0]
                Y2 = q[1]
                Z2 = q[2]
                if(i!=j){
                  d = Math.hypot(a=X1-X2, b=Y1-Y2, e=Z1-Z2)
                  if(d<mind) mind = d
                }
              })
            })
            a = []
            B.map((v,i)=>{
              X1 = v[0]
              Y1 = v[1]
              Z1 = v[2]
              B.map((q,j)=>{
                X2 = q[0]
                Y2 = q[1]
                Z2 = q[2]
                if(i!=j){
                  d = Math.hypot(X1-X2, Y1-Y2, Z1-Z2)
                  if(d<mind*2){
                    if(!a.filter(q=>q[0]==X2&&q[1]==Y2&&q[2]==Z2&&q[3]==X1&&q[4]==Y1&&q[5]==Z1).length) a = [...a, [X1*size,Y1*size,Z1*size,X2*size,Y2*size,Z2*size]]
                  }
                }
              })
            })
            B.map(v=>{
              v[0]*=size
              v[1]*=size
              v[2]*=size
              v[0]+=mx
              v[1]+=my
              v[2]+=mz
            })
            return [mx, my, mz, size, B, a]
          }

          lineFaceI = (X1, Y1, Z1, X2, Y2, Z2, facet, autoFlipNormals=false, showNormals=false) => {
            let X_, Y_, Z_, d, m, l_,K,J,L,p
            let I_=(A,B,M,D,E,F,G,H)=>(K=((G-E)*(B-F)-(H-F)*(A-E))/(J=(H-F)*(M-A)-(G-E)*(D-B)))>=0&&K<=1&&(L=((M-A)*(B-F)-(D-B)*(A-E))/J)>=0&&L<=1?[A+K*(M-A),B+K*(D-B)]:0
            let Q_=()=>[c.width/2+X_/Z_*600,c.height/2+Y_/Z_*600]
            let R_ = (Rl,Pt,Yw,m)=>{
              let M=Math, A=M.atan2, H=M.hypot
              X_=S(p=A(X_,Y_)+Rl)*(d=H(X_,Y_)),Y_=C(p)*d,X_=S(p=A(X_,Z_)+Yw)*(d=H(X_,Z_)),Z_=C(p)*d,Y_=S(p=A(Y_,Z_)+Pt)*(d=H(Y_,Z_)),Z_=C(p)*d
              if(m){ X_+=oX,Y_+=oY,Z_+=oZ }
            }
            let rotSwitch = m =>{
              switch(m){
                case 0: R_(0,0,Math.PI/2); break
                case 1: R_(0,Math.PI/2,0); break
                case 2: R_(Math.PI/2,0,Math.PI/2); break
              }        
            }
            let ax = 0, ay = 0, az = 0
            facet.map(q_=>{ ax += q_[0], ay += q_[1], az += q_[2] })
            ax /= facet.length, ay /= facet.length, az /= facet.length
            let b1 = facet[2][0]-facet[1][0], b2 = facet[2][1]-facet[1][1], b3 = facet[2][2]-facet[1][2]
            let c1 = facet[1][0]-facet[0][0], c2 = facet[1][1]-facet[0][1], c3 = facet[1][2]-facet[0][2]
            let crs = [b2*c3-b3*c2,b3*c1-b1*c3,b1*c2-b2*c1]
            d = Math.hypot(...crs)+.001
            let nls = 1 //normal line length
            crs = crs.map(q=>q/d*nls)
            let X1_ = ax, Y1_ = ay, Z1_ = az
            let flip = 1
            if(autoFlipNormals){
              let d1_ = Math.hypot(X1_-X1,Y1_-Y1,Z1_-Z1)
              let d2_ = Math.hypot(X1-(ax + crs[0]/99),Y1-(ay + crs[1]/99),Z1-(az + crs[2]/99))
              flip = d2_>d1_?-1:1
            }
            let X2_ = ax + (crs[0]*=flip), Y2_ = ay + (crs[1]*=flip), Z2_ = az + (crs[2]*=flip)
            if(showNormals){
              x.beginPath()
              X_ = X1_, Y_ = Y1_, Z_ = Z1_
              R_(Rl,Pt,Yw,1)
              if(Z_>0) x.lineTo(...Q_())
              X_ = X2_, Y_ = Y2_, Z_ = Z2_
              R_(Rl,Pt,Yw,1)
              if(Z_>0) x.lineTo(...Q_())
              x.lineWidth = 5
              x.strokeStyle='#f004'
              x.stroke()
            }

            let p1_ = Math.atan2(X2_-X1_,Z2_-Z1_)
            let p2_ = -(Math.acos((Y2_-Y1_)/(Math.hypot(X2_-X1_,Y2_-Y1_,Z2_-Z1_)+.001))+Math.PI/2)
            let isc = false, iscs = [false,false,false]
            X_ = X1, Y_ = Y1, Z_ = Z1
            R_(0,-p2_,-p1_)
            let rx_ = X_, ry_ = Y_, rz_ = Z_
            for(let m=3;m--;){
              if(isc === false){
                X_ = rx_, Y_ = ry_, Z_ = rz_
                rotSwitch(m)
                X1_ = X_, Y1_ = Y_, Z1_ = Z_ = 5, X_ = X2, Y_ = Y2, Z_ = Z2
                R_(0,-p2_,-p1_)
                rotSwitch(m)
                X2_ = X_, Y2_ = Y_, Z2_ = Z_
                facet.map((q_,j_)=>{
                  if(isc === false){
                    let l = j_
                    X_ = facet[l][0], Y_ = facet[l][1], Z_ = facet[l][2]
                    R_(0,-p2_,-p1_)
                    rotSwitch(m)
                    let X3_=X_, Y3_=Y_, Z3_=Z_
                    l = (j_+1)%facet.length
                    X_ = facet[l][0], Y_ = facet[l][1], Z_ = facet[l][2]
                    R_(0,-p2_,-p1_)
                    rotSwitch(m)
                    let X4_ = X_, Y4_ = Y_, Z4_ = Z_
                    if(l_=I_(X1_,Y1_,X2_,Y2_,X3_,Y3_,X4_,Y4_)) iscs[m] = l_
                  }
                })
              }
            }
            if(iscs.filter(v=>v!==false).length==3){
              let iscx = iscs[1][0], iscy = iscs[0][1], iscz = iscs[0][0]
              let pointInPoly = true
              ax=0, ay=0, az=0
              facet.map((q_, j_)=>{ ax+=q_[0], ay+=q_[1], az+=q_[2] })
              ax/=facet.length, ay/=facet.length, az/=facet.length
              X_ = ax, Y_ = ay, Z_ = az
              R_(0,-p2_,-p1_)
              X1_ = X_, Y1_ = Y_, Z1_ = Z_
              X2_ = iscx, Y2_ = iscy, Z2_ = iscz
              facet.map((q_,j_)=>{
                if(pointInPoly){
                  let l = j_
                  X_ = facet[l][0], Y_ = facet[l][1], Z_ = facet[l][2]
                  R_(0,-p2_,-p1_)
                  let X3_ = X_, Y3_ = Y_, Z3_ = Z_
                  l = (j_+1)%facet.length
                  X_ = facet[l][0], Y_ = facet[l][1], Z_ = facet[l][2]
                  R_(0,-p2_,-p1_)
                  let X4_ = X_, Y4_ = Y_, Z4_ = Z_
                  if(I_(X1_,Y1_,X2_,Y2_,X3_,Y3_,X4_,Y4_)) pointInPoly = false
                }
              })
              if(pointInPoly){
                X_ = iscx, Y_ = iscy, Z_ = iscz
                R_(0,p2_,0)
                R_(0,0,p1_)
                isc = [[X_,Y_,Z_], [crs[0],crs[1],crs[2]]]
              }
            }
            return isc
          }

          TruncatedOctahedron = ls => {
            let shp = [], a = []
            mind = 6e6
            for(let i=6;i--;){
              X = S(p=Math.PI*2/6*i+Math.PI/6)*ls
              Y = C(p)*ls
              Z = 0
              if(Y<mind) mind = Y
              a = [...a, [X, Y, Z]]
            }
            let theta = .6154797086703867
            a.map(v=>{
              X = v[0]
              Y = v[1] - mind
              Z = v[2]
              R(0,theta,0)
              v[0] = X
              v[1] = Y
              v[2] = Z+1.5
            })
            b = JSON.parse(JSON.stringify(a)).map(v=>{
              v[1] *= -1
              return v
            })
            shp = [...shp, a, b]
            e = JSON.parse(JSON.stringify(shp)).map(v=>{
              v.map(q=>{
                X = q[0]
                Y = q[1]
                Z = q[2]
                R(0,0,Math.PI)
                q[0] = X
                q[1] = Y
                q[2] = Z
              })
              return v
            })
            shp = [...shp, ...e]
            e = JSON.parse(JSON.stringify(shp)).map(v=>{
              v.map(q=>{
                X = q[0]
                Y = q[1]
                Z = q[2]
                R(0,0,Math.PI/2)
                q[0] = X
                q[1] = Y
                q[2] = Z
              })
              return v
            })
            shp = [...shp, ...e]

            coords = [
              [[3,1],[4,3],[4,4],[3,2]],
              [[3,4],[3,3],[2,4],[6,2]],
              [[1,4],[0,3],[0,4],[4,2]],
              [[1,1],[1,2],[6,4],[7,3]],
              [[3,5],[7,5],[1,5],[3,0]],
              [[2,5],[6,5],[0,5],[4,5]]
            ]
            a = []
            coords.map(v=>{
              b = []
              v.map(q=>{
                X = shp[q[0]][q[1]][0]
                Y = shp[q[0]][q[1]][1]
                Z = shp[q[0]][q[1]][2]
                b = [...b, [X,Y,Z]]
              })
              a = [...a, b]
            })
            shp = [...shp, ...a]
            return shp.map(v=>{
              v.map(q=>{
                q[0]/=3
                q[1]/=3
                q[2]/=3
                q[0]*=ls
                q[1]*=ls
                q[2]*=ls
              })
              return v
            })
          }

          Cylinder = (rw,cl,ls1,ls2) => {
            let a = []
            for(let i=rw;i--;){
              let b = []
              for(let j=cl;j--;){
                X = S(p=Math.PI*2/cl*j) * ls1
                Y = (1/rw*i-.5)*ls2
                Z = C(p) * ls1
                b = [...b, [X,Y,Z]]
              }
              //a = [...a, b]
              for(let j=cl;j--;){
                b = []
                X = S(p=Math.PI*2/cl*j) * ls1
                Y = (1/rw*i-.5)*ls2
                Z = C(p) * ls1
                b = [...b, [X,Y,Z]]
                X = S(p=Math.PI*2/cl*(j+1)) * ls1
                Y = (1/rw*i-.5)*ls2
                Z = C(p) * ls1
                b = [...b, [X,Y,Z]]
                X = S(p=Math.PI*2/cl*(j+1)) * ls1
                Y = (1/rw*(i+1)-.5)*ls2
                Z = C(p) * ls1
                b = [...b, [X,Y,Z]]
                X = S(p=Math.PI*2/cl*j) * ls1
                Y = (1/rw*(i+1)-.5)*ls2
                Z = C(p) * ls1
                b = [...b, [X,Y,Z]]
                a = [...a, b]
              }
            }
            b = []
            for(let j=cl;j--;){
              X = S(p=Math.PI*2/cl*j) * ls1
              Y = ls2/2
              Z = C(p) * ls1
              b = [...b, [X,Y,Z]]
            }
            //a = [...a, b]
            return a
          }

          Tetrahedron = size => {
            ret = []
            a = []
            let h = size/1.4142/1.25
            for(i=3;i--;){
              X = S(p=Math.PI*2/3*i) * size/1.25
              Y = C(p) * size/1.25
              Z = h
              a = [...a, [X,Y,Z]]
            }
            ret = [...ret, a]
            for(j=3;j--;){
              a = []
              X = 0
              Y = 0
              Z = -h
              a = [...a, [X,Y,Z]]
              X = S(p=Math.PI*2/3*j) * size/1.25
              Y = C(p) * size/1.25
              Z = h
              a = [...a, [X,Y,Z]]
              X = S(p=Math.PI*2/3*(j+1)) * size/1.25
              Y = C(p) * size/1.25
              Z = h
              a = [...a, [X,Y,Z]]
              ret = [...ret, a]
            }
            ax=ay=az=ct=0
            ret.map(v=>{
              v.map(q=>{
                ax+=q[0]
                ay+=q[1]
                az+=q[2]
                ct++
              })
            })
            ax/=ct
            ay/=ct
            az/=ct
            ret.map(v=>{
              v.map(q=>{
                q[0]-=ax
                q[1]-=ay
                q[2]-=az
              })
            })
            return ret
          }

          Cube = size => {
            for(CB=[],j=6;j--;CB=[...CB,b])for(b=[],i=4;i--;)b=[...b,[(a=[S(p=Math.PI*2/4*i+Math.PI/4),C(p),2**.5/2])[j%3]*(l=j<3?size/1.5:-size/1.5),a[(j+1)%3]*l,a[(j+2)%3]*l]]
            return CB
          }

          Octahedron = size => {
            ret = []
            let h = size/1.25
            for(j=8;j--;){
              a = []
              X = 0
              Y = 0
              Z = h * (j<4?-1:1)
              a = [...a, [X,Y,Z]]
              X = S(p=Math.PI*2/4*j) * size/1.25
              Y = C(p) * size/1.25
              Z = 0
              a = [...a, [X,Y,Z]]
              X = S(p=Math.PI*2/4*(j+1)) * size/1.25
              Y = C(p) * size/1.25
              Z = 0
              a = [...a, [X,Y,Z]]
              ret = [...ret, a]
            }
            return ret      
          }

          Dodecahedron = size => {
            ret = []
            a = []
            mind = -6e6
            for(i=5;i--;){
              X=S(p=Math.PI*2/5*i + Math.PI/5)
              Y=C(p)
              Z=0
              if(Y>mind) mind=Y
              a = [...a, [X,Y,Z]]
            }
            a.map(v=>{
              X = v[0]
              Y = v[1]-=mind
              Z = v[2]
              R(0, .553573, 0)
              v[0] = X
              v[1] = Y
              v[2] = Z
            })
            b = JSON.parse(JSON.stringify(a))
            b.map(v=>{
              v[1] *= -1
            })
            ret = [...ret, a, b]
            mind = -6e6
            ret.map(v=>{
              v.map(q=>{
                X = q[0]
                Y = q[1]
                Z = q[2]
                if(Z>mind)mind = Z
              })
            })
            d1=Math.hypot(ret[0][0][0]-ret[0][1][0],ret[0][0][1]-ret[0][1][1],ret[0][0][2]-ret[0][1][2])
            ret.map(v=>{
              v.map(q=>{
                q[2]-=mind+d1/2
              })
            })
            b = JSON.parse(JSON.stringify(ret))
            b.map(v=>{
              v.map(q=>{
                q[2]*=-1
              })
            })
            ret = [...ret, ...b]
            b = JSON.parse(JSON.stringify(ret))
            b.map(v=>{
              v.map(q=>{
                X = q[0]
                Y = q[1]
                Z = q[2]
                R(0,0,Math.PI/2)
                R(0,Math.PI/2,0)
                q[0] = X
                q[1] = Y
                q[2] = Z
              })
            })
            e = JSON.parse(JSON.stringify(ret))
            e.map(v=>{
              v.map(q=>{
                X = q[0]
                Y = q[1]
                Z = q[2]
                R(0,0,Math.PI/2)
                R(Math.PI/2,0,0)
                q[0] = X
                q[1] = Y
                q[2] = Z
              })
            })
            ret = [...ret, ...b, ...e]
            ret.map(v=>{
              v.map(q=>{
                q[0] *= size/2
                q[1] *= size/2
                q[2] *= size/2
              })
            })
            return ret
          }

          Icosahedron = size => {
            ret = []
            let B = [
              [[0,3],[1,0],[2,2]],
              [[0,3],[1,0],[1,3]],
              [[0,3],[2,3],[1,3]],
              [[0,2],[2,1],[1,0]],
              [[0,2],[1,3],[1,0]],
              [[0,2],[1,3],[2,0]],
              [[0,3],[2,2],[0,0]],
              [[1,0],[2,2],[2,1]],
              [[1,1],[2,2],[2,1]],
              [[1,1],[2,2],[0,0]],
              [[1,1],[2,1],[0,1]],
              [[0,2],[2,1],[0,1]],
              [[2,0],[1,2],[2,3]],
              [[0,0],[0,3],[2,3]],
              [[1,3],[2,0],[2,3]],
              [[2,3],[0,0],[1,2]],
              [[1,2],[2,0],[0,1]],
              [[0,0],[1,2],[1,1]],
              [[0,1],[1,2],[1,1]],
              [[0,2],[2,0],[0,1]],
            ]
            for(p=[1,1],i=38;i--;)p=[...p,p[l=p.length-1]+p[l-1]]
            phi = p[l]/p[l-1]
            a = [
              [-phi,-1,0],
              [phi,-1,0],
              [phi,1,0],
              [-phi,1,0],
            ]
            for(j=3;j--;ret=[...ret, b])for(b=[],i=4;i--;) b = [...b, [a[i][j],a[i][(j+1)%3],a[i][(j+2)%3]]]
            ret.map(v=>{
              v.map(q=>{
                q[0]*=size/2.25
                q[1]*=size/2.25
                q[2]*=size/2.25
              })
            })
            cp = JSON.parse(JSON.stringify(ret))
            out=[]
            a = []
            B.map(v=>{
              idx1a = v[0][0]
              idx2a = v[1][0]
              idx3a = v[2][0]
              idx1b = v[0][1]
              idx2b = v[1][1]
              idx3b = v[2][1]
              a = [...a, [cp[idx1a][idx1b],cp[idx2a][idx2b],cp[idx3a][idx3b]]]
            })
            out = [...out, ...a]
            return out
          }

          stroke = (scol, fcol, lwo=1, od=true, oga=1) => {
            if(scol){
              x.closePath()
              if(od) x.globalAlpha = .2*oga
              x.strokeStyle = scol
              x.lineWidth = Math.min(1000,100*lwo/Z)
              if(od) x.stroke()
              x.lineWidth /= 4
              x.globalAlpha = 1*oga
              x.stroke()
            }
            if(fcol){
              x.globalAlpha = 1*oga
              x.fillStyle = fcol
              x.fill()
            }
            x.globalAlpha = 1
          }

          subbed = (subs, size, sphereize, shape) => {
            for(let m=subs; m--;){
              base = shape
              shape = []
              base.map(v=>{
                l = 0
                X1 = v[l][0]
                Y1 = v[l][1]
                Z1 = v[l][2]
                l = 1
                X2 = v[l][0]
                Y2 = v[l][1]
                Z2 = v[l][2]
                l = 2
                X3 = v[l][0]
                Y3 = v[l][1]
                Z3 = v[l][2]
                if(v.length > 3){
                  l = 3
                  X4 = v[l][0]
                  Y4 = v[l][1]
                  Z4 = v[l][2]
                  if(v.length > 4){
                    l = 4
                    X5 = v[l][0]
                    Y5 = v[l][1]
                    Z5 = v[l][2]
                  }
                }
                mx1 = (X1+X2)/2
                my1 = (Y1+Y2)/2
                mz1 = (Z1+Z2)/2
                mx2 = (X2+X3)/2
                my2 = (Y2+Y3)/2
                mz2 = (Z2+Z3)/2
                a = []
                switch(v.length){
                  case 3:
                    mx3 = (X3+X1)/2
                    my3 = (Y3+Y1)/2
                    mz3 = (Z3+Z1)/2
                    X = X1, Y = Y1, Z = Z1, a = [...a, [X,Y,Z]]
                    X = mx1, Y = my1, Z = mz1, a = [...a, [X,Y,Z]]
                    X = mx3, Y = my3, Z = mz3, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = mx1, Y = my1, Z = mz1, a = [...a, [X,Y,Z]]
                    X = X2, Y = Y2, Z = Z2, a = [...a, [X,Y,Z]]
                    X = mx2, Y = my2, Z = mz2, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = mx3, Y = my3, Z = mz3, a = [...a, [X,Y,Z]]
                    X = mx2, Y = my2, Z = mz2, a = [...a, [X,Y,Z]]
                    X = X3, Y = Y3, Z = Z3, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = mx1, Y = my1, Z = mz1, a = [...a, [X,Y,Z]]
                    X = mx2, Y = my2, Z = mz2, a = [...a, [X,Y,Z]]
                    X = mx3, Y = my3, Z = mz3, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    break
                  case 4:
                    mx3 = (X3+X4)/2
                    my3 = (Y3+Y4)/2
                    mz3 = (Z3+Z4)/2
                    mx4 = (X4+X1)/2
                    my4 = (Y4+Y1)/2
                    mz4 = (Z4+Z1)/2
                    cx = (X1+X2+X3+X4)/4
                    cy = (Y1+Y2+Y3+Y4)/4
                    cz = (Z1+Z2+Z3+Z4)/4
                    X = X1, Y = Y1, Z = Z1, a = [...a, [X,Y,Z]]
                    X = mx1, Y = my1, Z = mz1, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    X = mx4, Y = my4, Z = mz4, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = mx1, Y = my1, Z = mz1, a = [...a, [X,Y,Z]]
                    X = X2, Y = Y2, Z = Z2, a = [...a, [X,Y,Z]]
                    X = mx2, Y = my2, Z = mz2, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    X = mx2, Y = my2, Z = mz2, a = [...a, [X,Y,Z]]
                    X = X3, Y = Y3, Z = Z3, a = [...a, [X,Y,Z]]
                    X = mx3, Y = my3, Z = mz3, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = mx4, Y = my4, Z = mz4, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    X = mx3, Y = my3, Z = mz3, a = [...a, [X,Y,Z]]
                    X = X4, Y = Y4, Z = Z4, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    break
                  case 5:
                    cx = (X1+X2+X3+X4+X5)/5
                    cy = (Y1+Y2+Y3+Y4+Y5)/5
                    cz = (Z1+Z2+Z3+Z4+Z5)/5
                    mx3 = (X3+X4)/2
                    my3 = (Y3+Y4)/2
                    mz3 = (Z3+Z4)/2
                    mx4 = (X4+X5)/2
                    my4 = (Y4+Y5)/2
                    mz4 = (Z4+Z5)/2
                    mx5 = (X5+X1)/2
                    my5 = (Y5+Y1)/2
                    mz5 = (Z5+Z1)/2
                    X = X1, Y = Y1, Z = Z1, a = [...a, [X,Y,Z]]
                    X = X2, Y = Y2, Z = Z2, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = X2, Y = Y2, Z = Z2, a = [...a, [X,Y,Z]]
                    X = X3, Y = Y3, Z = Z3, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = X3, Y = Y3, Z = Z3, a = [...a, [X,Y,Z]]
                    X = X4, Y = Y4, Z = Z4, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = X4, Y = Y4, Z = Z4, a = [...a, [X,Y,Z]]
                    X = X5, Y = Y5, Z = Z5, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = X5, Y = Y5, Z = Z5, a = [...a, [X,Y,Z]]
                    X = X1, Y = Y1, Z = Z1, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    break
                }
              })
            }
            if(sphereize){
              ip1 = sphereize
              ip2 = 1-sphereize
              shape = shape.map(v=>{
                v = v.map(q=>{
                  X = q[0]
                  Y = q[1]
                  Z = q[2]
                  d = Math.hypot(X,Y,Z)
                  X /= d
                  Y /= d
                  Z /= d
                  X *= size*.75*ip1 + d*ip2
                  Y *= size*.75*ip1 + d*ip2
                  Z *= size*.75*ip1 + d*ip2
                  return [X,Y,Z]
                })
                return v
              })
            }
            return shape
          }

          subDividedIcosahedron  = (size, subs, sphereize = 0) => subbed(subs, size, sphereize, Icosahedron(size))
          subDividedTetrahedron  = (size, subs, sphereize = 0) => subbed(subs, size, sphereize, Tetrahedron(size))
          subDividedOctahedron   = (size, subs, sphereize = 0) => subbed(subs, size, sphereize, Octahedron(size))
          subDividedCube         = (size, subs, sphereize = 0) => subbed(subs, size, sphereize, Cube(size))
          subDividedDodecahedron = (size, subs, sphereize = 0) => subbed(subs, size, sphereize, Dodecahedron(size))

          Rn = Math.random

          LsystemRecurse = (size, splits, p1, p2, stem, theta, LsystemReduction, twistFactor) => {
            if(size < .25) return
            let X1 = stem[0]
            let Y1 = stem[1]
            let Z1 = stem[2]
            let X2 = stem[3]
            let Y2 = stem[4]
            let Z2 = stem[5]
            let p1a = Math.atan2(X2-X1,Z2-Z1)
            let p2a = -Math.acos((Y2-Y1)/(Math.hypot(X2-X1,Y2-Y1,Z2-Z1)+.0001))+Math.PI
            size/=LsystemReduction
            for(let i=splits;i--;){
              X = 0
              Y = -size
              Z = 0
              R(0, theta, 0)
              R(0, 0, Math.PI*2/splits*i+twistFactor)
              R(0, p2a, 0)
              R(0, 0, p1a+twistFactor)
              X+=X2
              Y+=Y2
              Z+=Z2
              let newStem = [X2, Y2, Z2, X, Y, Z]
              Lshp = [...Lshp, newStem]
              LsystemRecurse(size, splits, p1+Math.PI*2/splits*i+twistFactor, p2+theta, newStem, theta, LsystemReduction, twistFactor)
            }
          }
          DrawLsystem = shp => {
            shp.map(v=>{
              x.beginPath()
              X = v[0]
              Y = v[1]
              Z = v[2]
              R(Rl,Pt,Yw,1)
              if(Z>0)x.lineTo(...Q())
              X = v[3]
              Y = v[4]
              Z = v[5]
              R(Rl,Pt,Yw,1)
              if(Z>0)x.lineTo(...Q())
              lwo = Math.hypot(v[0]-v[3],v[1]-v[4],v[2]-v[5])*4
              stroke('#0f82','',lwo)
            })

          }
          Lsystem = (size, splits, theta, LsystemReduction, twistFactor) => {
            Lshp = []
            stem = [0,0,0,0,-size,0]
            Lshp = [...Lshp, stem]
            LsystemRecurse(size, splits, 0, 0, stem, theta, LsystemReduction, twistFactor)
            Lshp.map(v=>{
              v[1]+=size*1.5
              v[4]+=size*1.5
            })
            return Lshp
          }

          Sphere = (ls, rw, cl) => {
            a = []
            ls/=1.25
            for(j = rw; j--;){
              for(i = cl; i--;){
                b = []
                X = S(p = Math.PI*2/cl*i) * S(q = Math.PI/rw*j) * ls
                Y = C(q) * ls
                Z = C(p) * S(q) * ls
                b = [...b, [X,Y,Z]]
                X = S(p = Math.PI*2/cl*(i+1)) * S(q = Math.PI/rw*j) * ls
                Y = C(q) * ls
                Z = C(p) * S(q) * ls
                b = [...b, [X,Y,Z]]
                X = S(p = Math.PI*2/cl*(i+1)) * S(q = Math.PI/rw*(j+1)) * ls
                Y = C(q) * ls
                Z = C(p) * S(q) * ls
                b = [...b, [X,Y,Z]]
                X = S(p = Math.PI*2/cl*i) * S(q = Math.PI/rw*(j+1)) * ls
                Y = C(q) * ls
                Z = C(p) * S(q) * ls
                b = [...b, [X,Y,Z]]
                a = [...a, b]
              }
            }
            return a
          }

          Torus = (rw, cl, ls1, ls2, parts=1, twists=0, part_spacing=1.5) => {
            let ret = [], tx=0, ty=0, tz=0, prl1 = 0, p2a = 0
            let tx1 = 0, ty1 = 0, tz1 = 0, prl2 = 0, p2b = 0, tx2 = 0, ty2 = 0, tz2 = 0
            for(let m=parts;m--;){
              avgs = Array(rw).fill().map(v=>[0,0,0])
              for(j=rw;j--;)for(let i = cl;i--;){
                if(parts>1){
                  ls3 = ls1*part_spacing
                  X = S(p=Math.PI*2/parts*m) * ls3
                  Y = C(p) * ls3
                  Z = 0
                  R(prl1 = Math.PI*2/rw*(j-1)*twists,0,0)
                  tx1 = X
                  ty1 = Y 
                  tz1 = Z
                  R(0, 0, Math.PI*2/rw*(j-1))
                  ax1 = X
                  ay1 = Y
                  az1 = Z
                  X = S(p=Math.PI*2/parts*m) * ls3
                  Y = C(p) * ls3
                  Z = 0
                  R(prl2 = Math.PI*2/rw*(j)*twists,0,0)
                  tx2 = X
                  ty2 = Y
                  tz2 = Z
                  R(0, 0, Math.PI*2/rw*j)
                  ax2 = X
                  ay2 = Y
                  az2 = Z
                  p1a = Math.atan2(ax2-ax1,az2-az1)
                  p2a = Math.PI/2+Math.acos((ay2-ay1)/(Math.hypot(ax2-ax1,ay2-ay1,az2-az1)+.001))

                  X = S(p=Math.PI*2/parts*m) * ls3
                  Y = C(p) * ls3
                  Z = 0
                  R(Math.PI*2/rw*(j)*twists,0,0)
                  tx1b = X
                  ty1b = Y
                  tz1b = Z
                  R(0, 0, Math.PI*2/rw*j)
                  ax1b = X
                  ay1b = Y
                  az1b = Z
                  X = S(p=Math.PI*2/parts*m) * ls3
                  Y = C(p) * ls3
                  Z = 0
                  R(Math.PI*2/rw*(j+1)*twists,0,0)
                  tx2b = X
                  ty2b = Y
                  tz2b = Z
                  R(0, 0, Math.PI*2/rw*(j+1))
                  ax2b = X
                  ay2b = Y
                  az2b = Z
                  p1b = Math.atan2(ax2b-ax1b,az2b-az1b)
                  p2b = Math.PI/2+Math.acos((ay2b-ay1b)/(Math.hypot(ax2b-ax1b,ay2b-ay1b,az2b-az1b)+.001))
                }
                a = []
                X = S(p=Math.PI*2/cl*i) * ls1
                Y = C(p) * ls1
                Z = 0
                //R(0,0,-p1a)
                R(prl1,p2a,0)
                X += ls2 + tx1, Y += ty1, Z += tz1
                R(0, 0, Math.PI*2/rw*j)
                a = [...a, [X,Y,Z]]
                X = S(p=Math.PI*2/cl*(i+1)) * ls1
                Y = C(p) * ls1
                Z = 0
                //R(0,0,-p1a)
                R(prl1,p2a,0)
                X += ls2 + tx1, Y += ty1, Z += tz1
                R(0, 0, Math.PI*2/rw*j)
                a = [...a, [X,Y,Z]]
                X = S(p=Math.PI*2/cl*(i+1)) * ls1
                Y = C(p) * ls1
                Z = 0
                //R(0,0,-p1b)
                R(prl2,p2b,0)
                X += ls2 + tx2, Y += ty2, Z += tz2
                R(0, 0, Math.PI*2/rw*(j+1))
                a = [...a, [X,Y,Z]]
                X = S(p=Math.PI*2/cl*i) * ls1
                Y = C(p) * ls1
                Z = 0
                //R(0,0,-p1b)
                R(prl2,p2b,0)
                X += ls2 + tx2, Y += ty2, Z += tz2
                R(0, 0, Math.PI*2/rw*(j+1))
                a = [...a, [X,Y,Z]]
                ret = [...ret, a]
              }
            }
            return ret
          }

          G_ = 100000, iSTc = 1e4
          ST = Array(iSTc).fill().map(v=>{
            X = (Rn()-.5)*G_
            Y = (Rn()-.5)*G_
            Z = (Rn()-.5)*G_
            return [X,Y,Z]
          })

          burst = new Image()
          burst.src = "burst.png"
          
          powerupsLoaded = false, powerupImgs = [{loaded: false}]
          powerupImgs = Array(2).fill().map((v,i) => {
            let a = {img: new Image(), loaded: false}
            a.img.onload = () => {
              a.loaded = true
              setTimeout(()=>{
                if(powerupImgs.filter(v=>v.loaded).length == 2) powerupsLoaded = true
              }, 0)
            }
            a.img.src = `powerup${i+1}.png`
            return a
          })

          crosshairsLoaded = false, crosshairImgs = [{loaded: false}]
          crosshairImgs = Array(3).fill().map((v,i) => {
            let a = {img: new Image(), loaded: false}
            a.img.onload = () => {
              a.loaded = true
              setTimeout(()=>{
                if(crosshairImgs.filter(v=>v.loaded).length == 3) crosshairsLoaded = true
              }, 0)
            }
            a.img.src = `crosshair${i+1}.png`
            return a
          })

          starsLoaded = false, starImgs = [{loaded: false}]
          starImgs = Array(9).fill().map((v,i) => {
            let a = {img: new Image(), loaded: false}
            a.img.onload = () => {
              a.loaded = true
              setTimeout(()=>{
                if(starImgs.filter(v=>v.loaded).length == 9) starsLoaded = true
              }, 0)
            }
            a.img.src = `star${i+1}.png`
            return a
          })

          floor = (X, Z) => {
            //return 0
            return ((50-Math.hypot(X,Z)/20-t*10)%50)
            return Math.max(0, C((d=Math.hypot(X, Z))/300)*200+((50-d/20-t*10)%50))
            //return (S(X/50+t*2) + S(Z/100))*4 * ((1+S(X/100+t)*C(Z/100))%1)*10 + ((S(X/1000)+C(Z/2000))*200)
            //return Math.min(20, Math.max(-20, S(X/500+t/2)*100 + S(Z/150+t)*100)) + ((S(X/400) + S(Z/200)) * ((1+S(X/100)*C(Z/100)))*10 + ((S(X/1000)+C(Z/2000))*200))
            //return Math.max(-2000, Math.min(2000, (C(Z/100)*25 + C(X/100)*25)**5/2e4))
            //return Math.max(-20,Math.min(20,100-(S(X/400+t/2+Math.hypot(X/400,Z/400))*150 * C(Z/400))))
            p = Math.atan2(X+=400, Z -= 800) + Math.PI/4
            d = Math.hypot(X, Z)
            X = S(p) * d
            Z = C(p) * d
            return Math.min(50, Math.max(-50, ((C(X/400) + S(Z/400))*10)**3/20))
          }
          
          spawnCar = (X=0, Y=0, Z=0, uid=userID) => {
            let car = {
              X,
              Y,
              Z,
              vx: 0,
              vy: 0,
              vz: 0,
              yw: 0,
              pt: 0,
              rl: 0,
              rlv: 0,
              ptv: 0,
              ywv: 0,
              speed: 0,
              curGun: 0,
              camMode: 0,
              id: uid,
              gunTheta: 0,
              gunThetav: 0,
              powerups: [
                {
                  name: 'speedBoost',
                  val: 1,
                  timer: 0,
                  duration: 5
                },
                {
                  name: 'guns++',
                  val: 1,
                  timer: 0,
                  duration: 20
                }
              ],
              shotTimer: 0,
              forward: true,
              shooting: false,
              shotInterval: 1,
              grounded: false,
              powerupTimer: 0,
              poweredUp: false,
              name: playerName,
              keys: Array(256).fill(),
              decon: JSON.parse(JSON.stringify(base_car_decon)),
              distanceTravelled: 0
            }
            return car
          }
          
          async function masterInit(){
            powerupTemplate = [
              {
                name: 'speedBoost',
                val: 1,
                duration: 5
              },
              {
                name: 'guns++',
                val: 1,
                duration: 20
              }
            ]
            cams = []
            grav = .66
            iCarsc = 1
            sparks = []
            camDist = 7
            flashes = []
            bullets = []
            iSparkv = .4
            iBulletv = 16
            maxSpeed = 40
            powerups = []
            carTrails = []
            showDash = true
            showCars = true
            camSelected = 0
            maxCamDist = 25
            crosshairSel = 0
            showGyro = false
            smokeTrails = []
            powerupFreq = 500
            showstars = true
            mapChoice= 'topo'
            showFloor = true
            camModeStyles = 2
            camFollowSpeed = 2
            maxTurnRadius = .1
            showCrosshair = true
            keyTimerInterval = 1/60*10 // .5 sec
            keyTimers = Array(256).fill(0)
            base_gun = Cylinder(1,8,.6,1.5).map(v=>{
              v.map(q=>{
                X = q[0]
                Y = q[1]
                Z = q[2]
                R3(0,Math.PI/2,0)
                q[0] = X
                q[1] = Y
                q[2] = Z
              })
              return v
            })
            base_car = await loadOBJ('car_no_wheels.obj', 1, 0, 0, 0, 0, 0, Math.PI)
            base_wheel = await loadOBJ('car_wheel.obj', 1, 0, 0, 0, 0, 0, Math.PI)
            base_car_lowpoly = await loadOBJ('car_no_wheels_lowpoly.obj', 1, 0, -1, -1.5, 0, 0, Math.PI)
            base_wheel_lowpoly = await loadOBJ('car_wheel_lowpoly.obj', 1, 0, 0, 0, 0, 0, Math.PI)
            base_car_decon = JSON.parse(JSON.stringify(base_car)).map(v=>{
              v = [0, 0, 0,  // X,   Y,   Z
                   0, 0, 0,  // vx,  vy,  vz
                   0, 0, 0,  // rl,  pt,  yw
                   0, 0, 0,  // rlv, ptv, ywv
                   ] 
              return v
            })
            
            spawnSparksCmd             = []
            PlayerCount                = 0
          }
          await masterInit()
          
          PlayerInit = (idx, uid) => { // called initially & when a player dies
            //Players[idx].score1         = score1
            //Players[idx].score2         = score2
            //Players[idx].totalPcs1      = totalPcs1
            //Players[idx].totalPcs2      = totalPcs2
            //Players[idx].P1Ojama        = P1Ojama
            //Players[idx].P2Ojama        = P2Ojama
            //Players[idx].B1alive        = B1alive
            //Players[idx].B2alive        = B2alive
            Players[idx].car              = idx ? spawnCar(0,0,0, uid) : cars[0]
            Players[idx].spawnSparksCmd   = spawnSparksCmd
          }


          addPlayers = playerData => {
            playerData.score = 0
            Players = [...Players, {playerData}]
            PlayerCount++
            PlayerInit(Players.length-1, playerData.id)
          }

          spawnCam = car => {
            
            X = car.X
            Z = car.Z - camDist
            Y = floor(X, Z) - 10
            R(0, 0, 0)
            return {
              X, Y, Z
            }
          }
          
          cars = Array(iCarsc).fill().map(v => {
            X = 0, Z = 0
            Y = floor(X, Z)
            let car = spawnCar(X,Y,Z) 
            car.cam = spawnCam(car)
            return car
          })
            
          oX=0, oY=0, oZ=30
          Rl=0, Pt=-.125, Yw=0
          
          
          c.onkeydown = e => {
            e.preventDefault()
            e.stopPropagation()
            cars[0].keys[e.keyCode] = true
          }

          c.onkeyup = e => {
            e.preventDefault()
            e.stopPropagation()
            cars[0].keys[e.keyCode] = false
          }
          
          doKeys = () => {
            curCar = cars[camSelected]
            curCar.shooting = false
            cars[0].keys.map((v,i) => {
              if(v){
                switch(i){
                  case  84:
                    if(keyTimers[i] < t){
                      keyTimers[i] = t+keyTimerInterval
                      showDash = !showDash
                    }
                  break
                  case  67:
                    if(keyTimers[i] < t){
                      keyTimers[i] = t+keyTimerInterval
                      if(showCrosshair && crosshairSel<crosshairImgs.length-1){
                        crosshairSel++
                      }else{
                        crosshairSel=0
                        showCrosshair = !showCrosshair
                      }
                    }
                  break
                  case 48:
                    if(camSelected == 0 && keyTimers[i] < t){
                      keyTimers[i] = t+keyTimerInterval
                      curCar.camMode++
                      curCar.camMode %= camModeStyles
                    }else{
                      camSelected = 0
                    }
                    break
                  case 65:
                    if(curCar.grounded){
                      d1 = Math.hypot(curCar.vx,curCar.vz)
                      curCar.ywv -= .04
                      curCar.ywv = Math.min(maxTurnRadius, Math.max(-maxTurnRadius, curCar.ywv))
                    }
                    break
                  case 37:
                    if(curCar.grounded){
                      d1 = Math.hypot(curCar.vx,curCar.vz)
                      curCar.ywv -= .04
                      curCar.ywv = Math.min(maxTurnRadius, Math.max(-maxTurnRadius, curCar.ywv))
                    }
                    break
                  case 87:
                    if(curCar.grounded){
                      let boost = curCar.powerups.filter(powerup=>powerup.name=='speedBoost')[0].val
                      curCar.vx += S(curCar.yw) * .08 * boost
                      curCar.vz += C(curCar.yw) * .08 * boost
                      d1 = Math.hypot(curCar.vx,curCar.vy,curCar.vz)
                      d2 = Math.min(maxSpeed, d1)
                      curCar.vx /=d1
                      curCar.vz /=d1
                      curCar.vx *=d2
                      curCar.vz *=d2
                    }
                    break
                  case 38:
                    if(curCar.grounded){
                      let boost = curCar.powerups.filter(powerup=>powerup.name=='speedBoost')[0].val
                      curCar.vx += S(curCar.yw) * .08 * boost
                      curCar.vz += C(curCar.yw) * .08 * boost
                      d1 = Math.hypot(curCar.vx,curCar.vy,curCar.vz)
                      d2 = Math.min(maxSpeed, d1)
                      curCar.vx /=d1
                      curCar.vz /=d1
                      curCar.vx *=d2
                      curCar.vz *=d2
                    }
                    break
                  case 68:
                    if(curCar.grounded){
                      d1 = Math.hypot(curCar.vx,curCar.vz)
                      curCar.ywv += .04
                      curCar.ywv = Math.min(maxTurnRadius, Math.max(-maxTurnRadius, curCar.ywv))
                    }
                    break
                  case 39:
                    if(curCar.grounded){
                      d1 = Math.hypot(curCar.vx,curCar.vz)
                      curCar.ywv += .04
                      curCar.ywv = Math.min(maxTurnRadius, Math.max(-maxTurnRadius, curCar.ywv))
                    }
                    break
                  case 83:
                    if(curCar.grounded){
                      let boost = curCar.powerups.filter(powerup=>powerup.name=='speedBoost')[0].val
                      curCar.vx -= S(curCar.yw) * .04 * boost
                      curCar.vz -= C(curCar.yw) * .04 * boost
                      d1 = Math.hypot(curCar.vx,curCar.vy,curCar.vz)
                      d2 = Math.min(maxSpeed, d1)
                      curCar.vx /=d1
                      curCar.vz /=d1
                      curCar.vx *=d2
                      curCar.vz *=d2
                    }
                    break
                  case 40:
                    if(curCar.grounded){
                      let boost = curCar.powerups.filter(powerup=>powerup.name=='speedBoost')[0].val
                      curCar.vx -= S(curCar.yw) * .04 * boost
                      curCar.vz -= C(curCar.yw) * .04 * boost
                      d1 = Math.hypot(curCar.vx,curCar.vy,curCar.vz)
                      d2 = Math.min(maxSpeed, d1)
                      curCar.vx /=d1
                      curCar.vz /=d1
                      curCar.vx *=d2
                      curCar.vz *=d2
                    }
                    break
                  case 17:
                    curCar.shooting = true
                    shoot(curCar)
                    break
                }
              }
            })
          }
          window.onload = () => {c.focus()}
          
          spawnBullet = car => {
            floatingCam = !car.camMode
            sd = curCar.curGun
            ls = car.curGun > 1 ? 1 : 0
            for(let i=sd; i--;){
              px = S(p=Math.PI*2/sd*i+car.gunTheta)
              py = C(p)
              X = px/2
              Y = py/2
              Z = iBulletv
              if(floatingCam){
                R3(car.rl, car.pt, car.yw)
              }else{
                R3(curCar.rl/1.5, curCar.pt/1.25-.03, curCar.yw)
              }
              vx = X + car.vx
              vy = Y
              vz = Z + car.vz
              X = px*ls
              Y = py*ls - (floatingCam ? 3 : 3.5)
              Z = 4
              if(floatingCam){
                carFunc(car)
              }else{
                R3(car.rl,car.pt,car.yw)
              }
              X += car.X + (floatingCam ? car.vx : 0)
              Y += car.Y
              Z += car.Z + (floatingCam ? car.vz : 0)
              spawnFlash(X, Y, Z, .025)
              bullets = [...bullets, [X, Y-(floatingCam?0:.1), Z, vx, vy, vz, 1]]
            }
          }
          
          shoot = car => {
            if(car.shotTimer<t){
              car.shotTimer = t + 1/60*car.shotInterval
              spawnBullet(car)
            }
          }
          
          carFunc = car =>{
            Y+=2
            Z+=2
            R3(car.rl/1.5, car.pt/1.25, car.yw)
            //R3(car.rl, car.pt, car.yw)
            Y-=2
            Z-=2
          }
          
          spawnFlash = (X, Y, Z, size = 1) => {
            for(let m = 1; m--;){
              flashes = [...flashes, [X,Y,Z,size]]
            }
          }
          
          spawnSparks = (X, Y, Z, intensity) => {
            intensity = Math.min(20,intensity)
            for(let m = 20 + intensity*4|0; m--;){
              let p1 = Rn()*Math.PI*2
              let p2 = Rn()<.5 ? Math.PI - Rn()**.5*Math.PI/2: Rn()**.5*Math.PI/2
              let pv = .05+Rn()**.5*(iSparkv+intensity/200 - .05)
              vx = S(p1) * S(p2) * pv
              vy = -Math.abs(C(p2) * pv*1.5)
              vz = C(p1) * S(p2) * pv
              sparks = [...sparks, [X,Y,Z,vx,vy,vz,1+intensity/10]]
            }
          }
          
          spawnPowerup = () => {
            let type
            cars.map(car => {
              ls = 10 + Rn()**.5*490
              X = car.X + S(p=Math.PI*2*Rn()) * ls
              Z = car.Z + C(p) * ls
              Y = floor(X, Z) - 3
              type = (Rn()**2*powerupTemplate.length)|0
              initVal = powerupTemplate[type].val
              duration = powerupTemplate[type].duration
              nm = powerupTemplate[type].name
              powerups = [...powerups, [X,Y,Z,0,0,0,type,initVal,nm,duration]]
            })
          }
          
          drawCar = (car, idx, col1='#0f83', col2="") => {
            
            while(car.yw > Math.PI*4) car.yw-=Math.PI*8
            while(car.yw < -Math.PI*4) car.yw+=Math.PI*8
            while(car.pt > Math.PI*4) car.pt-=Math.PI*8
            while(car.pt < -Math.PI*4) car.pt+=Math.PI*8
            while(car.rl > Math.PI*4) car.rl-=Math.PI*8
            while(car.rl < -Math.PI*4) car.rl+=Math.PI*8
            
            let ox = car.X
            let oy = car.Y
            let oz = car.Z
            
            fl = floor(car.X, car.Z)
            ocg = car.grounded
            car.grounded = car.Y >= fl - 1
            car.vy /= 1.01
            car.X += car.vx
            car.Y += car.vy += grav
            car.Z += car.vz
            
            X=Y=0, Z = 1
            R3(0,0,car.yw)
            X1 = X, Y1 = Y, Z1 = Z
            X=Y=0, Z = -1
            R3(0,0,car.yw)
            X2 = X, Y2 = Y, Z2 = Z
            X3 = car.vx
            Z3 = car.vz
            d1 = Math.hypot(X3-X1,Z3-Z1)
            d2 = Math.hypot(X3-X2,Z3-Z2)
            car.forward = d2>=d1-.1
            
            d1 = Math.hypot(car.vx,car.vz)
            car.speed = d1
            car.distanceTravelled += d1 * (car.forward? 1 : -1)
            dx=dy=dz=0
            car.rl += car.rlv
            car.pt += car.ptv
            if(car.grounded) car.yw += car.ywv * 24 *  Math.min(.04, d1/maxSpeed/2) * (cars.keys[40] ? -1 : 1) * (car.keys[40] || car.keys[83] ? -1 : 1)
            car.rlv /= 1.005
            car.ptv /= 1.005
            car.ywv /= 1.005
            sparkWheels = false
            if(car.grounded){
              if(!ocg && car.vy>1){
                intensity = car.vy*5
                sparkWheels = true
                if(car.vy > 6){
                  car.curGun = 0
                  car.decon.map(v=>{
                    v[3] += (Rn() - .5) * intensity /4
                    v[4] += (Rn() - .5) * intensity /4
                    v[5] += (Rn() - .5) * intensity /4
                    v[6] += (Rn() - .5) * intensity /4
                    v[7] += (Rn() - .5) * intensity /4
                    v[8] += (Rn() - .5) * intensity /4
                  })
                }
                car.vy*=-.5
              }else{
                car.vy /= 1.5
              }
              if(!car.keys[38] && !car.keys[40]){
                car.vx /= 1.06
                car.vz /= 1.06
              }else{
                car.vx /= 1.015
                car.vz /= 1.015
              }
              car.rlv /= 1.25
              car.ptv /= 1.25
              car.ywv /= 1.25
            }else{
              car.rl += car.rlv/1.4
              car.pt += car.ptv/1.4
              car.yw += car.ywv/1.4
            }

            fl = floor(car.X, car.Z)
            car.Y = Math.min(fl, car.Y)
            
            dy = Math.min(0, (car.Y - oy)/2) / (1+Math.abs(fl-car.Y))
            car.vy += Math.max(-5, dy*2)
            
            let carx = car.X
            let cary = car.Y
            let carz = car.Z
            

            if(car.grounded){
              X = -4
              Y = 0
              Z = 0
              R3(0, 0, car.yw)
              floor1 = floor(X+carx, Z+carz)
              X = 4
              Y = 0
              Z = 0
              R3(0, 0, car.yw)
              floor2 = floor(X+carx, Z+carz)

              X = 0
              Y = 0
              Z = -8
              R3(0, 0, car.yw)
              floor3 = floor(X+carx, Z+carz)
              X = 0
              Y = 0
              Z = 8
              R3(0, 0, car.yw)
              floor4 = floor(X+carx, Z+carz)
              car.ptv += Math.min(.1,Math.max(-.1,((floor4-floor3)/16-car.pt)/8))
              car.rlv += Math.min(.1,Math.max(-.1,((floor1-floor2)/8-car.rl)/8))
            }

            if(car.camMode && idx == 0){
              olc = x.lineCap
              x.lineJoin = x.lineCap = 'butt';
              (idx && Math.hypot(car.X-cars[0].X,car.Y-cars[0].Y,car.Z-cars[0].Z)>50 ? base_car_lowpoly : base_car_lowpoly).map((v, i) => {
                x.beginPath()
                ax=ay=az = 0
                v.map((q, j) => {
                  ax += q[0]
                  ay += q[1]
                  az += q[2]
                })
                ax /= v.length
                ay /= v.length
                az /= v.length
                
                v.map((q, j) => {
                  for(m=12;m--;)car.decon[i][m]/=1.1
                  dconx = (car.decon[i][0] += car.decon[i][3])
                  dcony = (car.decon[i][1] += car.decon[i][4])
                  dconz = (car.decon[i][2] += car.decon[i][5])
                  X = q[0] -ax
                  Y = q[1] -ay
                  Z = q[2] -az
                  R3(car.decon[i][6] += car.decon[i][9], car.decon[i][7] += car.decon[i][10], car.decon[i][8] += car.decon[i][11])
                  X += 0 + dconx + ax
                  Y += 3.5 + dcony + ay
                  Z += 4 + dconz + az
                  X*=2
                  l = Q2()
                  if(Z>4.5 && l[1]>c.height/3 && i>80) x.lineTo(...l)
                })
                alpha = (l[1]/c.height/2)**4*5
                if(alpha > .05) stroke(col1,col2,3,true,alpha)
              })
              
              for(n=4; n--;){
                if(sparkWheels){
                  X = (n%2?1.5:-1.5)
                  Y = 1
                  Z = ((n/2|0)?3.8:-3.8)-1.2
                  spawnSparks(car.X+X,car.Y+Y,car.Z+Z,intensity)
                };
                (idx && Math.hypot(car.X-cars[0].X,car.Y-cars[0].Y,car.Z-cars[0].Z)>30 ? base_wheel_lowpoly : base_wheel).map((v, i) => {
                  if((!car.forward && car.keys[38] || car.forward && car.keys[40])&& Rn()<.1){
                    let poly = JSON.parse(JSON.stringify(v)).map(q => {
                      X = q[0]
                      Y = q[1]
                      Z = q[2]
                      X += (n%2?2.5:-2.5)
                      Y -= 1.1
                      Z += ((n/2|0)?3.8:-3.8)-3
                      carFunc(car)
                      q[0] = X*2
                      q[1] = Y
                      q[2] = Z
                      q[3] = car.vx/2
                      q[4] = 0
                      q[5] = car.vz/2
                      q[6] = 1
                      q[7] = car.X
                      q[8] = car.Y
                      q[9] = car.Z
                      return q
                    })
                    smokeTrails = [...smokeTrails, poly]
                  }
                  x.beginPath()
                  v.map((q, j) => {
                    dconx = (car.decon[i][0] += car.decon[i][3])
                    dcony = (car.decon[i][1] += car.decon[i][4])
                    dconz = (car.decon[i][2] += car.decon[i][5])
                    X = q[0] //-ax
                    Y = q[1] //-ay
                    Z = q[2] //-az
                    R3(car.decon[i][6] += car.decon[i][9], car.decon[i][7] += car.decon[i][10], car.decon[i][8] += car.decon[i][11])
                    X = q[0] + dconx
                    Y = q[1]+1.1 + dcony
                    Z = q[2] + dconz
                    if(!(n%2)) R3(0,0,Math.PI)
                    R3(0,car.distanceTravelled,0)
                    if(n/2|0) R3(0,0,car.ywv*8)
                    X += (n%2?2.5:-2.5)
                    Y -= 1.1
                    Z += ((n/2|0)?3.8:-3.8)-1.2
                    X *= 2
                    Y += 3.5
                    Z += 4
                    l = Q2()
                    if(Z>1) x.lineTo(...l)
                  })
                  alpha = (l[1]/c.height/2)**4*10
                  stroke('#0005','#f043',1,false,alpha)
                })
              }
              x.lineJoin = x.lineCap = olc
              
              if(showCrosshair){
                x.globalAlpha = .2
                s=800
                x.drawImage(crosshairImgs[crosshairSel].img,c.width/2-s/2,c.height/2-s/2,s,s)
                x.globalAlpha = 1
                x.lineJoin = x.lineCap = olc
                //x.lineCap = x.lineJoin = 'round'
              }
              
              //guns
              sd = car.curGun
              ls = car.curGun>1 ? 1 : 0
              for(let i = sd; i--;){
                tx = S(p=Math.PI*2/sd*i+car.gunTheta)*ls
                ty = C(p)*ls
                tz = 0
                car.gunThetav+=car.shooting?.02:0
                car.gunTheta += car.gunThetav
                car.gunThetav /=1.25
                base_gun.map((v,i) => {
                  x.beginPath()
                  v.map((q, j) => {
                    X = q[0]
                    Y = q[1]
                    Z = q[2]
                    R3(car.gunTheta,0,0)
                    X += tx
                    Y += ty
                    Z += tz + 3
                    //R3(car.rl,car.pt,car.yw)
                    //X += car.X
                    //Y += car.Y
                    //Z += car.Z
                    //R(Rl,Pt,Yw,1)
                    if(Z>0)x.lineTo(...Q2())
                  })
                  stroke('#4f81','',1,false)
                })
              }
              x.lineCap = x.lineJoin = 'butt'
            }else{
              x.lineJoin = x.lineCap = 'butt';
              (idx && Math.hypot(car.X-cars[0].X,car.Y-cars[0].Y,car.Z-cars[0].Z)>50 ? base_car_lowpoly : base_car).map((v, i) => {
                ax=ay=az = 0
                v.map((q, j) => {
                  ax += q[0]
                  ay += q[1]
                  az += q[2]
                })
                ax /= v.length
                ay /= v.length
                az /= v.length
                if(car.poweredUp && Rn()<.05){
                  let poly = JSON.parse(JSON.stringify(v)).map(q => {
                    X = q[0]
                    Y = q[1]
                    Z = q[2]
                    carFunc(car)
                    q[0] = X
                    q[1] = Y
                    q[2] = Z
                    q[3] = car.vx/1.25
                    q[4] = 0
                    q[5] = car.vz/1.25
                    q[6] = 1
                    q[7] = car.X
                    q[8] = car.Y
                    q[9] = car.Z
                    return q
                  })
                  carTrails = [...carTrails, poly]
                }
                
                x.beginPath()
                v.map((q, j) => {
                  for(m=12;m--;)car.decon[i][m]/=1.1
                  d = Math.hypot(car.decon[i][0],car.decon[i][0],car.decon[i][0])
                  dconx = (car.decon[i][0] += car.decon[i][3])
                  dcony = (car.decon[i][1] += car.decon[i][4]+=(d>.1?grav/3:0))
                  dconz = (car.decon[i][2] += car.decon[i][5])
                  if(dcony + cary + ay >= (f=floor(carx+ax+dconx, carz+az+dconz))){
                    car.decon[i][4] = (car.decon[i][4]>0 ? -car.decon[i][4] : car.decon[i][4]) * .7
                    dcony = car.decon[i][1] += car.decon[i][4]
                  }
                  X = q[0] -ax
                  Y = q[1] -ay
                  Z = q[2] -az
                  R3(car.decon[i][6] += car.decon[i][9], car.decon[i][7] += car.decon[i][10], car.decon[i][8] += car.decon[i][11])
                  X += ax
                  Y += ay
                  Z += az
                  carFunc(car)
                  X += dconx
                  Y += dcony
                  Z += dconz
                  X += carx
                  Y += cary
                  Z += carz
                  R(Rl,Pt,Yw,1)
                  if(Z>0) x.lineTo(...Q())
                })
                stroke(col1,col2,3,false)
              })
              
              for(n=4; n--;){
                if(sparkWheels){
                  X = (n%2?1.5:-1.5)
                  Y = 1
                  Z = ((n/2|0)?3.8:-3.8)-1.2
                  spawnSparks(car.X+X,car.Y+Y,car.Z+Z,intensity)
                };
                ((idx && Math.hypot(car.X-cars[0].X,car.Y-cars[0].Y,car.Z-cars[0].Z)>50 ? base_wheel_lowpoly : base_wheel)).map((v, i) => {
                  if((!car.forward && car.keys[38] || car.forward && car.keys[40] )&& Rn()<.1){
                    let poly = JSON.parse(JSON.stringify(v)).map(q => {
                      X = q[0]
                      Y = q[1]
                      Z = q[2]
                      X += (n%2?2.5:-2.5)
                      Y -= 1.1
                      Z += ((n/2|0)?3.8:-3.8)-1.2
                      carFunc(car)
                      q[0] = X
                      q[1] = Y
                      q[2] = Z
                      q[3] = car.vx/2
                      q[4] = 0
                      q[5] = car.vz/2
                      q[6] = 1
                      q[7] = car.X
                      q[8] = car.Y
                      q[9] = car.Z
                      return q
                    })
                    smokeTrails = [...smokeTrails, poly]
                  }
                  
                  x.beginPath()
                  v.map((q, j) => {
                    dconx = (car.decon[i][0] += car.decon[i][3])
                    dcony = (car.decon[i][1] += car.decon[i][4])
                    dconz = (car.decon[i][2] += car.decon[i][5])
                    X = q[0] -ax
                    Y = q[1] -ay
                    Z = q[2] -az
                    R3(car.decon[i][6] += car.decon[i][9], car.decon[i][7] += car.decon[i][10], car.decon[i][8] += car.decon[i][11])
                    X = q[0] + dconx
                    Y = q[1]+1.1 + dcony
                    Z = q[2] + dconz
                    if(!(n%2)) R3(0,0,Math.PI)
                    R3(0,car.distanceTravelled,0)
                    if(n/2|0) R3(0,0,car.ywv*8)
                    X += (n%2?2.5:-2.5)
                    Y -= 1.1
                    Z += ((n/2|0)?3.8:-3.8)-1.2
                    carFunc(car)
                    X += carx
                    Y += cary
                    Z += carz
                    R(Rl,Pt,Yw,1)
                    if(Z>0) x.lineTo(...Q())
                  })
                  stroke('#0005','#f043',1,false)
                })
              }
              
              //guns
              //x.lineJoin = x.lineCap = 'round'
              sd = car.curGun
              ls = car.curGun>1 ? 1 : 0
              for(let i = sd; i--;){
                tx = S(p=Math.PI*2/sd*i+car.gunTheta)*ls
                ty = C(p)*ls
                tz = 0
                car.gunThetav+=car.shooting?.02:0
                car.gunTheta += car.gunThetav
                car.gunThetav /=1.25
                base_gun.map((v,i) => {
                  x.beginPath()
                  v.map((q, j) => {


                    X = q[0]
                    Y = q[1]
                    Z = q[2]
                    R3(car.gunTheta,0,0)
                    X += tx
                    Y += ty - 3
                    Z += tz + 3
                    carFunc(car)
                    X += car.X
                    Y += car.Y
                    Z += car.Z
                    R(Rl,Pt,Yw,1)
                    if(Z>0)x.lineTo(...Q())
                  })
                  stroke('#4f86','',4,false)
                })
              }
              
              
              if(showGyro){
                x.beginPath()
                X = 0
                Y = -3
                Z = 0
                carFunc(car)
                X += car.X
                Y += car.Y
                Z += car.Z
                R(Rl,Pt,Yw,1)
                if(Z>0) x.lineTo(...Q())
                X = 0
                Y = -3
                Z = 5
                carFunc(car)
                X += car.X
                Y += car.Y
                Z += car.Z
                R(Rl,Pt,Yw,1)
                if(Z>0) x.lineTo(...Q())
                stroke('#f008', '', 5, true)

                x.beginPath()
                X = 0
                Y = -3
                Z = 0
                carFunc(car)
                X += car.X
                Y += car.Y
                Z += car.Z
                R(Rl,Pt,Yw,1)
                if(Z>0) x.lineTo(...Q())
                X = 5
                Y = -3
                Z = 0
                carFunc(car)
                X += car.X
                Y += car.Y
                Z += car.Z
                R(Rl,Pt,Yw,1)
                if(Z>0) x.lineTo(...Q())
                stroke('#f008', '', 5, true)

                x.beginPath()
                X = 0
                Y = -3
                Z = 0
                carFunc(car)
                X += car.X
                Y += car.Y
                Z += car.Z
                R(Rl,Pt,Yw,1)
                if(Z>0) x.lineTo(...Q())
                X = 0
                Y = -8
                Z = 0
                carFunc(car)
                X += car.X
                Y += car.Y
                Z += car.Z
                R(Rl,Pt,Yw,1)
                if(Z>0) x.lineTo(...Q())
                stroke('#f008', '', 5, true)
              }
            }
          }
        }

        curCar = cars[camSelected]
        switch(curCar.camMode){
          case 0:
            d = Math.hypot(curCar.vx, curCar.vz)
            cd = Math.min(maxCamDist, camDist + d/2)
            dx = curCar.cam.X - curCar.X
            dy = curCar.cam.Y - curCar.Y
            dz = curCar.cam.Z - curCar.Z
            d = Math.hypot(dx,dy,dz)
            nx = S(t/4)*cd
            nz = C(t/4)*cd
            X = dx/d*cd-nx + curCar.X
            Z = dz/d*cd-nz + curCar.Z
            Y = Math.min(floor(X,Z)-cd, dy/d*cd-cd/2  + curCar.Y)
            tgtx = X
            tgty = Y
            tgtz = Z
            curCar.cam.X -= (curCar.cam.X - tgtx)/camFollowSpeed
            curCar.cam.Y -= (curCar.cam.Y - tgty)/camFollowSpeed
            curCar.cam.Z -= (curCar.cam.Z - tgtz)/camFollowSpeed
            oX = curCar.cam.X
            oZ = curCar.cam.Z
            oY = curCar.cam.Y
            Pt = -Math.acos((oY-curCar.Y) / (Math.hypot(oX-curCar.X,oY-curCar.Y,oZ-curCar.Z)+.001))+Math.PI/2
            Yw = -Math.atan2(curCar.X-oX,curCar.Z-oZ)
            Rl = 0
            break
          case 1:
            X = 0
            Y = -5
            Z = 25
            R3(0,curCar.pt,0)
            R3(0,0,curCar.yw)
            X_ = X+=curCar.X
            Y_ = Y+=curCar.Y
            Z_ = Z+=curCar.Z
            X = 0
            Y = -3
            Z = 1
            R3(0,curCar.pt,0)
            R3(0,0,curCar.yw)
            oX = curCar.cam.X = curCar.X - X
            oY = curCar.cam.Y = curCar.Y - 3
            oZ = curCar.cam.Z = curCar.Z - Z
            Pt = -Math.acos((oY-Y_) / (Math.hypot(oX-X_,oY-Y_,oZ-Z_)+.001))+Math.PI/2
            Yw = -Math.atan2(X_-oX,Z_-oZ)
            Rl = -curCar.rl
            break
        }
        
        x.globalAlpha = 1
        x.fillStyle='#000C'
        x.fillRect(0,0,c.width,c.height)
        x.lineJoin = x.lineCap = 'butt'

        doKeys()
        if(!((t*60|0)%((powerupFreq/powerupTemplate.length)|0))) spawnPowerup()
        
        if(showstars) ST.map(v=>{
          X = v[0]
          Y = v[1]
          Z = v[2]
          R(Rl,Pt,Yw,1)
          if(Z>0){
            if((x.globalAlpha = Math.min(1,(Z/5e3)**2))>.1){
              s = Math.min(1e3, 4e5/Z)
              x.fillStyle = '#ffffff04'
              l = Q()
              x.fillRect(l[0]-s/2,l[1]-s/2,s,s)
              s/=5
              x.fillStyle = '#fffa'
              x.fillRect(l[0]-s/2,l[1]-s/2,s,s)
            }
          }
        })

        x.globalAlpha = 1
        
        if(showFloor){
          
          cars.map(car => {
            
            let carx = car.X
            let carz = car.Z
            let cary = car.Y

            if(showFloor){
              rw = 128
              cl = rw/3|0
              sp = 8
              ls = sp/3.5//.75**.5*sp/2
              Array(rw*cl).fill().map((v, i) => {
                if(!((i+(i/cl/5|0))%3)){
                  tx = ((i%cl)-cl/2+.5)*sp
                  ty = 0
                  tz = (((i/cl|0)%rw)-rw/2+.5)*sp * (.75**2/2)
                  while(carz-tz>rw*sp*(.75**2/2)/2){
                    tz+=rw*sp*(.75**2/2)
                  }
                  while(carz-tz<-rw*sp*(.75**2/2)/2){
                    tz-=rw*sp*(.75**2/2)
                  }
                  ct = 0
                  while(carx-tx>cl*sp/2 && ct<1e3){
                    tx+=cl*sp
                    ct++
                  }
                  ct = 0
                  while(carx-tx<-cl*sp/2 && ct<1e3){
                    tx-=cl*sp
                    ct++
                  }
                    
                  x.beginPath()
                  ay = 0
                  for(j=6;j--;){
                    X = tx + S(p=Math.PI*2/6*j+Math.PI/6) * ls + ((i/cl|0)%2?sp/2:0)
                    Z = tz + C(p) * ls
                    Y = ty + floor(X, Z)
                    ay += Y
                    R(Rl,Pt,Yw,1)
                    if(Z>0) x.lineTo(...Q())
                  }
                  d1 = Math.hypot(tx-carx,tz-carz)
                  if(d1<rw){
                    ay /= 6
                    alpha = 1 / (1+d1**8/1e15)
                    col1 = ''//`hsla(${ay*3},99%,50%,${.5}`
                    col2= `hsla(${ay*3+180},99%,50%,${.3}`
                    if(alpha>.1) stroke(col1, col2, 5, false, alpha)
                  }
                }
              })
            }
          })
        }
        x.globalAlpha = 1
        
        if(showCars) {
          cars.map((car, idx) => {
            car.powerups.map((powerup, idx) => {
              switch(idx){
                case 0:
                  if(powerup.timer){
                    car.poweredUp = true
                    col1 = `hsla(${t*15000},99%,50%,1)`
                    col2 = `hsla(${t*15000},99%,50%,.2)`
                    drawCar(car, idx, col1, col2)
                  }
                break
                case 1:
                  if(powerup.timer){
                    car.curGun++
                    powerup.timer = 0
                    powerup.val=0
                  }
                break
              }
              if(powerup.timer && powerup.timer <=t){
                powerup.timer = 0
                powerup.val = 1
                car.poweredUp = false
              }
            })
            if(!car.poweredUp){
              drawCar(car, idx)
            }
          })
        }
          
        x.globalAlpha = 1


        powerups = powerups.filter(v=>v[7]>0)
        powerups.map(v=>{
          let starIdx
          X = v[0]
          Z = v[2]
          Y = v[1] = floor(X,Z) - 3
          cars.map(car=>{
            X2 = car.X
            Y2 = car.Y
            Z2 = car.Z
            if(Math.hypot(X2-X,Y2-Y,Z2-Z)<25){
              spawnFlash(X,Y,Z)
              switch(v[6]){
                case 0:
                  car.powerups[v[6]].val++
                  car.powerups[v[6]].timer = t + v[9]
                  break
                case 1:
                  //car.powerups[v[6]].val++
                  car.powerups[v[6]].timer = t + v[9]
                  break
              }
              v[7]=0
            }
          })
          R(Rl,Pt,Yw,1)
          if(Z>0){
            s = Math.min(1e4, 8e4/Z)
            l = Q()
            switch(v[6]){
              case 0:  //speedBoost
                starIdx = 4
              break
              case 1:  //guns++
                starIdx = 1
              break
            }
            x.drawImage(starImgs[starIdx].img,l[0]-s/2/1.065, l[1]-s/2/1.065,s,s)
          }

          X = v[0]
          Z = v[2]
          Y = v[1] = floor(X,Z) - 3
          R(Rl,Pt,Yw,1)
          if(Z>0){
            s = Math.min(4e3, 2e4/Z)
            l = Q()
            x.drawImage(powerupImgs[v[6]].img,l[0]-s/2, l[1]-s/2-15000/Z,s,s)
            x.textAlign = 'center'
            x.font = (fs=20000/Z)+'px Courier Prime'
            x.fillStyle = '#fff'
            x.fillText((v[7]*100|0),l[0], l[1]-30000/Z,s,s)
          }
          v[7] -= .0025
        })

        carTrails = carTrails.filter(v => {
          v = v.filter(q=>q[6]>0)
          return !!v.length
        })
        carTrails.map(v=>{
          x.beginPath()
          v.map(q => {
            q[7] += q[3]/=1.01
            q[8] += q[4]/=1.01
            q[9] += q[5]/=1.01
            X = (q[0] *= 1.05) + q[7]
            Y = (q[1] *= 1.05) + q[8]
            Z = (q[2] *= 1.05) + q[9]
            R(Rl,Pt,Yw,1)
            if(Z>0) x.lineTo(...Q())
            a=q[6] -= .05
          })
          
          stroke('', '#f0f6',1,false,Math.max(0,a))
        })

        smokeTrails = smokeTrails.filter(v => {
          v = v.filter(q=>q[6]>0)
          return !!v.length
        })
        smokeTrails.map(v=>{
          x.beginPath()
          v.map(q => {
            q[7] += q[3]/=1.01
            q[8] += q[4]/=1.01
            q[9] += q[5]/=1.01
            X = (q[0] *= 1.05) + q[7]
            Y = (q[1] *= 1.05) + q[8]
            Z = (q[2] *= 1.05) + q[9]
            R(Rl,Pt,Yw,1)
            if(Z>0) x.lineTo(...Q())
            a=q[6] -= .025
          })
          stroke('', '#6666',1,false,Math.max(0, a))
        })

        bullets = bullets.filter(v=>v[6]>0)
        bullets.map(v => {
          X = v[0] += v[3]
          Y = v[1] += v[4]
          Z = v[2] += v[5]
          R(Rl,Pt,Yw,1)
          if(Z>0){
            l = curCar.camMode?Q2():Q()
            s = Math.min(1e5,2e4/Z*v[6])
            x.drawImage(burst,l[0]-s/2,l[1]-s/2,s,s)
            //s/=2
            //x.drawImage(starImgs[4].img,l[0]-s/2/1.05,l[1]-s/2/1.05,s,s)
          }
          v[6] -= .025
        })

        flashes = flashes.filter(v=>v[3]>0)
        flashes.map(v=>{
          X = v[0]
          Y = v[1]
          Z = v[2]
          R(Rl,Pt,Yw,1)
          if(Z>0){
            l = curCar.camMode?Q2():Q()
            s = Math.min(1e5,5e5/Z*v[3])
            x.drawImage(starImgs[5].img,l[0]-s/2/1.05,l[1]-s/2/1.05,s,s)
          }
          v[3] -= .1
        })

        sparks = sparks.filter(v=>v[6]>0)
        sparks.map(v=>{
          X = v[0] += v[3]
          Y = v[1] += v[4]
          Z = v[2] += v[5]
          R(Rl,Pt,Yw,1)
          if(Z>0){
            l = Q()
            s = Math.min(1e4,600/Z*v[6])
            x.fillStyle = '#ff000006'
            x.fillRect(l[0]-s/2,l[1]-s/2,s,s)
            s/=3
            x.fillStyle = '#ff880010'
            x.fillRect(l[0]-s/2,l[1]-s/2,s,s)
            s/=3
            x.fillStyle = '#ffffffff'
            x.fillRect(l[0]-s/2,l[1]-s/2,s,s)
          }
          v[6]-=.1
        })
        
        x.globalAlpha = 1

        if(showDash){
          
          olc = x.lineJoin
          x.lineJoin = x.lineCap = 'butt'
          ls     = 200
          margin = 55

          switch(mapChoice){
            case 'topo':
              x.lineJoin = x.lineCap = 'round'
              let mapRes = 50
              let sp = 8
              let scl = 3, fl
              x.font = (fs=60) + 'px Courier Prime'
              x.textAlign = 'left'
              x.fillStyle = '#444'
              x.fillText('◄ ►', c.width - margin*4 - mapRes*sp, fs)
              x.fillStyle = '#fff'
              x.textAlign = 'right'
              x.fillText('MAP: TOPO', c.width - margin, fs)
              if(1)for(i=mapRes**2;i--;){
                X = ((i%mapRes)-mapRes/2+.5)*sp
                Y = ((i/mapRes|0)-mapRes/2+.5)*sp
                if(Math.hypot(X,Y)<ls*1.25){
                  worldX =  X * scl
                  worldZ =  Y * scl
                  tx = X, ty = Y, tz = Z
                  X = worldX
                  Y = 0
                  Z = worldZ
                  R3(0,0,-curCar.yw)
                  worldX = X + curCar.X
                  worldZ = Z - curCar.Z
                  X = tx, Y = ty, Z = tz
                  s = sp*1.3
                  fl = floor(worldX, -worldZ)
                  x.fillStyle = `hsla(${fl*3+180},99%,50%,.5)`
                  x.fillRect(c.width - margin/2 - mapRes*sp/2 + X - s/2, margin*1.66 + mapRes*sp/2 + Y - s/2, s, s)
                }
              }
              powerups.map(v=>{
                X = (v[0] - curCar.X)/scl
                Z = (v[2] - curCar.Z)/scl
                if(Math.hypot(X,Z)<ls*1.25){
                  Y = 0
                  R3(0,0,-curCar.yw)
                  s = sp*1.3*4
                  x.drawImage(powerupImgs[v[6]].img,c.width - margin/2 - mapRes*sp/2 + X - s/2, margin*1.66 + mapRes*sp/2 - Z - s/2, s, s)
                }
              })
              
              ls/=2
              s=250
              x.beginPath()
              let p_ = 0//curCar.yw
              X = c.width - margin/2 - mapRes*sp/2+ S(-p_)*ls/5
              Y = margin*1.66 + mapRes*sp/2 + C(-p_)*ls/5
              x.lineTo(X,Y)
              X = c.width - margin/2 - mapRes*sp/2
              Y = margin*1.66 + mapRes*sp/2
              x.lineTo(X,Y)
              tx = X += S(p=-p_+Math.PI)* ls/5
              ty = Y += C(p)* ls/5
              x.lineTo(X,Y)
              X += S(p+Math.PI/1.3)*ls/8
              Y += C(p+Math.PI/1.3)*ls/8
              x.lineTo(X,Y)
              x.lineTo(X=tx,Y=ty)
              X += S(p-Math.PI/1.3)*ls/8
              Y += C(p-Math.PI/1.3)*ls/8
              x.lineTo(X,Y)
              x.lineTo(tx,ty)
              Z=3
              stroke('#000','',2.5/2,false)

              stroke('#f00','',.5/2,true)
              //x.drawImage(starImgs[5].img,c.width - margin/2 - mapRes*sp/2 + 0 - s/2, margin*1.66 + mapRes*sp/2 + 0 - s/2, s, s)

              bullets.map(v=>{
                X = (v[0] - curCar.X)/scl
                Z = (v[2] - curCar.Z)/scl
                if(Math.hypot(X,Z)<ls*1.25){
                  Y = 0
                  R3(0,0,-curCar.yw)
                  s = sp*1.3*4
                  x.drawImage(starImgs[0].img,c.width - margin/2 - mapRes*sp/2 + X - s/2, margin*1.66 + mapRes*sp/2 - Z - s/2, s, s)
                }
              })

              x.lineJoin = x.lineCap = 'butt'
            break
            default:
            break
          }
          

          ls     = 200
          margin = 55
          
          //backlight
          x.beginPath()
          x.lineTo(-20,ls*2 + margin*3.25)
          x.lineTo(-20,-20)
          x.lineTo(c.width+20,-20)
          x.lineTo(c.width+20,Y_=ls*2+margin*3.25)
          x.lineTo(c.width - c.width/6,Y_=ls*2+margin*3.25)
          for(i=0;i<100;i++){
            X = c.width - c.width/6 - c.width*(2/3)/99*i
            Y = Y_ + (C(Math.PI/99*i)**4*ls-ls)*2.5
            x.lineTo(X,Y)
          }
          x.lineTo(-20,Y_=ls*2+margin*3.25)
          Z = 3
          col1 = curCar.forward ? '#0f82' : '#f002'
          col2 = curCar.forward ? '#0f82' : '#f042'
          stroke(col1, col2, 2)
          
          // speedometer
          margin += 15
          Z = 3
          col    = '#4ff'
          x.beginPath()
          x.arc(margin+ls,margin+ls,ls,0,7)
          stroke(col,'#4f82')
          sd     = 10
          opi    = -Math.PI*2/10
          x.textAlign = 'center'
          for(i=sd+1;i--;){
            x.font = (fs = 32) + 'px Courier Prime'
            x.fillStyle = '#fff'
            X = ls+margin+S(p=Math.PI*2/(sd+2)*-i+opi)*ls*1.2
            Y = ls+margin+C(p)*ls*1.2
            x.fillText(i*40,X,Y+fs/3)
          }
          sd     = 100
          for(i=sd+1;i--;){
            x.beginPath()
            f = !(i%10)?.75:(!(i%5)?.85:.95)
            X = ls+margin+S(p=Math.PI*2/(sd+20)*-i+opi)*(ls*f)
            Y = ls+margin+C(p)*(ls*f)
            x.lineTo(X,Y)
            X = ls+margin+S(p=Math.PI*2/(sd+20)*-i+opi)*ls
            Y = ls+margin+C(p)*ls
            x.lineTo(X,Y)
            Z=3
            stroke(col,'',.2,true)
          }
          x.beginPath()
          x.lineTo(margin+ls,margin+ls)
          X = ls+margin+S(p=Math.PI*2/(sd+2)*-(curCar.speed*Math.PI)+opi)*(ls*.8)
          Y = ls+margin+C(p)*(ls*.8)
          x.lineTo(X,Y)
          stroke('#f04','',2,true)
          margin -=15
          x.beginPath()
          x.lineTo(margin/2,ls*2+margin*2)
          x.lineTo(margin/2+ls/1.5,ls*2+margin*2)
          x.lineTo(margin/2+ls/1.5,ls*2+margin*3)
          x.lineTo(margin/2,ls*2+margin*3)
          Z=3
          x.textAlign = 'center'
          stroke(col,'#4f82',.2,true)
          x.fillStyle = '#fff'
          x.font = (fs = 60) + 'px Courier Prime'
          x.fillText((Math.round(curCar.speed*15)),margin*1.75,margin*3+ls*2-fs/6)
          x.textAlign = 'right'
          x.fillText('MPH ',margin+ls*1.5,margin*3+ls*2-fs/5)
          
          // reverse warning
          if(!curCar.forward && ((t*60|0)%6<3)){
            x.textAlign = 'center'
            x.font = (fs = 60) + 'px Courier Prime'
            x.fillStyle = '#f00'
            x.fillText('>>> REVERSE WARNING <<<', c.width/2-100, +fs/1.1)
          }else{
            x.textAlign = 'left'
            x.font = (fs = 50) + 'px Courier Prime'
            x.fillStyle = '#0f8'
            let bval = curCar.powerups[0].val
            x.fillText(`BOOST ${bval-1} ` + ('>'.repeat(bval-1)), c.width/2-300, fs/1.5)
            x.strokeStyle = '#4f82'
            x.lineWidth = 10
            x.strokeRect(c.width/2-300, fs-10,400,30)
            if(bval>1){
              x.fillStyle = '#f08'
              x.fillRect(c.width/2-300, fs-10,400 * (curCar.powerups[0].timer-t)/curCar.powerups[0].duration,30)
            }
          }
          x.lineJoin = x.lineCap = olc
        }

        t+=1/60
        requestAnimationFrame(Draw)
      }

      alphaToDec = val => {
        let pow=0
        let res=0
        let cur, mul
        while(val!=''){
          cur=val[val.length-1]
          val=val.substring(0,val.length-1)
          mul=cur.charCodeAt(0)<58?cur:cur.charCodeAt(0)-(cur.charCodeAt(0)>96?87:29)
          res+=mul*(62**pow)
          pow++
        }
        return res
      }

      regFrame = document.querySelector('#regFrame')
      launchModal = document.querySelector('#launchModal')
      launchStatus = document.querySelector('#launchStatus')
      gameLink = document.querySelector('#gameLink')

      launch = () => {
        let none = false
        if((none = typeof users == 'undefined') || users.length<2){
          alert("this game requires at least one other player to join!\n\nCurrent users joined: " + (none ? 0 : users.length))
          return
        }
        launchModal.style.display = 'none'
        launched = true
        Draw()
      }

      doJoined = jid => {
        regFrame.style.display = 'none'
        regFrame.src = ''
        userID = +jid
        sync()
      }

      fullSync = false
      individualPlayerData = {}
      syncPlayerData = users => {
        users.map((user, idx) => {
          if((typeof Players != 'undefined') &&
             (l=Players.filter(v=>v.playerData.id == user.id).length)){
            l[0] = user
            fullSync = true
          }else if(launched && t){
            addPlayers(user)
          }
        })
        
        if(launched){
          Players = Players.filter((v, i) => {
            if(!users.filter(q=>q.id==v.playerData.id).length){
              cams = cams.filter((cam, idx) => idx != i)
            }
            return users.filter(q=>q.id==v.playerData.id).length
          })
          iCamsc = Players.length
          Players.map((AI, idx) => {
            if(AI.playerData.id == userID){
              individualPlayerData['id'] = userID
              individualPlayerData['name'] = AI.playerData.name
              individualPlayerData['time'] = AI.playerData.time
              //if(typeof score != 'undefined') {
              //  AI.score = score
              //  AI.playerData.score = score
              //  individualPlayerData['score'] = score
              //}
              
              if(typeof cars == 'object' && cars.length){
                individualPlayerData['car'] = cars[0]
              }
              
              /*
              if(typeof B1 != 'undefined'){
                if(B1.length){
                  individualPlayerData['B1'] = B1
                }
              }
              if(typeof P1 != 'undefined'){
                if(P1.length){
                  individualPlayerData['P1'] = P1
                }
              }
              
              if(typeof P2Ojama != 'undefined') {
                individualPlayerData['P2Ojama'] = P2Ojama
                P2Ojama = 0
              }*/


              //if(typeof score1 != 'undefined') individualPlayerData['score1'] = score1
              //if(typeof score2 != 'undefined') individualPlayerData['score2'] = score2
              //if(typeof totalPcs1 != 'undefined') individualPlayerData['totalPcs1'] = totalPcs1
              //if(typeof totalPcs2 != 'undefined') individualPlayerData['totalPcs2'] = totalPcs2

              //if(typeof B1alive != 'undefined') individualPlayerData['B1alive'] = B1alive
              if(typeof spawnSparksCmd != 'undefined') {
                individualPlayerData['spawnSparksCmd'] = JSON.parse(JSON.stringify(spawnSparksCmd))
                spawnSparksCmd = []
              }
              //if(typeof gameInPlay != 'undefined') individualPlayerData['gameInPlay'] = gameInPlay
              
              //if(typeof moves != 'undefined') individualPlayerData['moves'] = moves
              //if(typeof lastWinnerWasOp != 'undefined' && lastWinnerWasOp != -1) individualPlayerData['lastWinnerWasOp'] = lastWinnerWasOp
            }else{
              if(AI.playerData?.id){
                el = users.filter(v=>+v.id == +AI.playerData.id)[0]
                Object.entries(AI).forEach(([key,val]) => {
                  switch(key){
                    
                    // straight mapping of incoming data <-> players

                    //case 'score2': if(typeof el[key] != 'undefined') score1 = el[key]; break;
                    //case 'totalPcs1': if(typeof el[key] != 'undefined') totalPcs2 = el[key]; break;
                    case 'car':
                      if(typeof el[key] != 'undefined'){
                        cars = cars.map(v=>{
                          if(+v.id == +el[key].id){
                            v = el[key]
                          }
                          return v
                        })
                      }
                    break;
                    /*case 'P1':
                      if(typeof el[key] != 'undefined'){
                        P2 = el[key]
                      }
                    break;
                    
                    case 'P2Ojama': if(typeof el[key] != 'undefined') P1Ojama += el[key]; break;
                    case 'B1alive': if(typeof el[key] != 'undefined') B2alive = el[key]; break;
                    //case 'gameInPlay': if(typeof el[key] != 'undefined') gameInPlay = el[key]; break;
                    case 'spawnSparksCmd': if(typeof el[key] != 'undefined') {
                      el[key].map(v=>{
                        v[0] += 16
                        spawnSparks(...v, 0)
                      })
                      break;
                    }*/
                    
                    //case 'lastWinnerWasOp': if(typeof el[key] != 'undefined' && el[key] != -1) lastWinnerWasOp = el[key]; break;
                    //case 'score':
                    //  if(typeof el[key] != 'undefined'){
                    //    AI[key] = +el[key]
                    //    AI.playerData[key] = +el[key]
                    //  }
                    //break;
                  }
                })
              }
            }
          })
          for(i=0;i<Players.length;i++) if(Players[i]?.playerData?.id == userID) ofidx = i
        }
      }

      Players              = []
      recData              = []
      opIsX = true
      ofidx                = 0
      users                = []
      userID               = ''
      gameConnected        = false
      playerName           = ''
      sync = () => {
        let sendData = {
          gameID,
          userID,
          individualPlayerData,
          //collected: 0
        }
        fetch('sync.php',{
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(sendData),
        }).then(res=>res.json()).then(data=>{
          if(data[0]){
            recData = data[1]
            if(data[3] && userID != gmid){
              individualPlayerData = recData.players[data[3]]
            }
            users = []
            Object.entries(recData.players).forEach(([key,val]) => {
              val.id = key
              users = [...users, val]
            })
            
            syncPlayerData(users)
            
            if(userID) playerName = recData.players[data[3]]['name']
            if(data[2]){ //needs reg
              regFrame.style.display = 'block'
              regFrame.src = `reg.php?g=${gameSlug}&gmid=${gmid}` 
            }else{
              if(!gameConnected){
                setInterval(()=>{sync()}, pollFreq = 1000)  //ms
                gameConnected = true
              }
              if(!launched){
                launchStatus.innerHTML = ''
                users.map(user=>{
                  launchStatus.innerHTML      += user.name
                  launchStatus.innerHTML      += ` joined...`
                  if(user.id == gmid){
                    launchStatus.innerHTML    += ` [game master]`
                  }
                  launchStatus.innerHTML      += `<br>`
                })
                launchStatus.innerHTML      += `<br>`.repeat(4)
                launchButton = document.createElement('button')
                launchButton.innerHTML = 'launch!'
                launchButton.className = 'buttons'
                launchButton.onclick = () =>{ launch() }
                launchStatus.appendChild(launchButton)
                if(gameLink.innerHTML == ''){
                  launchModal.style.display = 'block'
                  resultLink = document.createElement('div')
                  resultLink.className = 'resultLink'
                  if(pchoice){
                    resultLink.innerHTML = location.href.split(pchoice+userID).join('')
                  }else{
                    resultLink.innerHTML = location.href
                  }
                  gameLink.appendChild(resultLink)
                  copyButton = document.createElement('button')
                  copyButton.title = "copy link to clipboard"
                  copyButton.className = 'copyButton'
                  copyButton.onclick = () => { copy() }
                  gameLink.appendChild(copyButton)
                }
              }
            }
          }else{
            console.log(data)
            console.log('error! crap')
          }
        })
      }

      fullCopy = () => {
        launchButton = document.createElement('button')
        launchButton.innerHTML = 'launch!'
        launchButton.className = 'buttons'
        launchButton.onclick = () =>{ launch() }
        launchStatus.appendChild(launchButton)
        gameLink.innerHTML = ''
        launchModal.style.display = 'block'
        resultLink = document.createElement('div')
        resultLink.className = 'resultLink'
        if(location.href.indexOf('&p=')!=-1){
          resultLink.innerHTML = location.href.split('&p='+userID).join('')
        }else{
          resultLink.innerHTML = location.href
        }
        gameLink.appendChild(resultLink)
        copyButton = document.createElement('button')
        copyButton.className = 'copyButton'
        gameLink.appendChild(copyButton)
        copy()
        launchModal.style.display = 'none'
        setTimeout(()=>{
          mbutton = mbutton.map(v=>false)
        },0)
      }

      copy = () => {
        var range = document.createRange()
        range.selectNode(document.querySelectorAll('.resultLink')[0])
        window.getSelection().removeAllRanges()
        window.getSelection().addRange(range)
        document.execCommand("copy")
        window.getSelection().removeAllRanges()
        let el = document.querySelector('#copyConfirmation')
        el.style.display = 'block';
        el.style.opacity = 1
        reduceOpacity = () => {
          if(+el.style.opacity > 0){
            el.style.opacity -= .02 * (launched ? 4 : 1)
            if(+el.style.opacity<.1){
              el.style.opacity = 1
              el.style.display = 'none'
            }else{
              setTimeout(()=>{
                reduceOpacity()
              }, 10)
            }
          }
        }
        setTimeout(()=>{reduceOpacity()}, 250)
      }
      
      userID = launched = pchoice = false
      if(location.href.indexOf('gmid=') !== -1){
        href = location.href
        if(href.indexOf('?g=') !== -1) gameSlug = href.split('?g=')[1].split('&')[0]
        if(href.indexOf('&g=') !== -1) gameSlug = href.split('&g=')[1].split('&')[0]
        if(href.indexOf('?gmid=') !== -1) gmid = href.split('?gmid=')[1].split('&')[0]
        if(href.indexOf('&gmid=') !== -1) gmid = href.split('&gmid=')[1].split('&')[0]
        if(href.indexOf('?p=') !== -1) userID = href.split(pchoice='?p=')[1].split('&')[0]
        if(href.indexOf('&p=') !== -1) userID = href.split(pchoice='&p=')[1].split('&')[0]
        gameID = alphaToDec(gameSlug)
        if(gameID) sync(gameID)

        if(userID == gmid){
          turnID = 0
        }else{
          turnID = 1
        }
      }























/*



      c = document.querySelector('#c')
      c.width = 1920
      c.height = 1080
      x = c.getContext('2d')
      C = Math.cos
      S = Math.sin
      t = 0
      T = Math.tan

      rsz=window.onresize=()=>{
        setTimeout(()=>{
          if(document.body.clientWidth > document.body.clientHeight*1.77777778){
            c.style.height = '100vh'
            setTimeout(()=>c.style.width = c.clientHeight*1.77777778+'px',0)
          }else{
            c.style.width = '100vw'
            setTimeout(()=>c.style.height =     c.clientWidth/1.77777778 + 'px',0)
          }
        },0)
      }
      rsz()

      async function Draw(){
        oX=oY=oZ=0
        if(!t){
          window.onload = () => {
            c.focus()
          }
          HSVFromRGB = (R, G, B) => {
            let R_=R/256
            let G_=G/256
            let B_=B/256
            let Cmin = Math.min(R_,G_,B_)
            let Cmax = Math.max(R_,G_,B_)
            let val = Cmax //(Cmax+Cmin) / 2
            let delta = Cmax-Cmin
            let sat = Cmax ? delta / Cmax: 0
            let min=Math.min(R,G,B)
            let max=Math.max(R,G,B)
            let hue = 0
            if(delta){
              if(R>=G && R>=B) hue = (G-B)/(max-min)
              if(G>=R && G>=B) hue = 2+(B-R)/(max-min)
              if(B>=G && B>=R) hue = 4+(R-G)/(max-min)
            }
            hue*=60
            while(hue<0) hue+=360;
            while(hue>=360) hue-=360;
            return [hue, sat, val]
          }

          RGBFromHSV = (H, S, V) => {
            while(H<0) H+=360;
            while(H>=360) H-=360;
            let C = V*S
            let X = C * (1-Math.abs((H/60)%2-1))
            let m = V-C
            let R_, G_, B_
            if(H>=0 && H < 60)    R_=C, G_=X, B_=0
            if(H>=60 && H < 120)  R_=X, G_=C, B_=0
            if(H>=120 && H < 180) R_=0, G_=C, B_=X
            if(H>=180 && H < 240) R_=0, G_=X, B_=C
            if(H>=240 && H < 300) R_=X, G_=0, B_=C
            if(H>=300 && H < 360) R_=C, G_=0, B_=X
            let R = (R_+m)*256
            let G = (G_+m)*256
            let B = (B_+m)*256
            return [R,G,B]
          }
          
          R=R2=(Rl,Pt,Yw,m)=>{
            M=Math
            A=M.atan2
            H=M.hypot
            X=S(p=A(X,Z)+Yw)*(d=H(X,Z))
            Z=C(p)*d
            Y=S(p=A(Y,Z)+Pt)*(d=H(Y,Z))
            Z=C(p)*d
            X=S(p=A(X,Y)+Rl)*(d=H(X,Y))
            Y=C(p)*d
            if(m){
              X+=oX
              Y+=oY
              Z+=oZ
            }
          }
          Q=()=>[c.width/2+X/Z*700,c.height/2+Y/Z*700]
          I=(A,B,M,D,E,F,G,H)=>(K=((G-E)*(B-F)-(H-F)*(A-E))/(J=(H-F)*(M-A)-(G-E)*(D-B)))>=0&&K<=1&&(L=((M-A)*(B-F)-(D-B)*(A-E))/J)>=0&&L<=1?[A+K*(M-A),B+K*(D-B)]:0
          
          Rn = Math.random
          async function loadOBJ(url, scale, tx, ty, tz, rl, pt, yw) {
            let res
            await fetch(url, res => res).then(data=>data.text()).then(data=>{
              a=[]
              data.split("\nv ").map(v=>{
                a=[...a, v.split("\n")[0]]
              })
              a=a.filter((v,i)=>i).map(v=>[...v.split(' ').map(n=>(+n.replace("\n", '')))])
              ax=ay=az=0
              a.map(v=>{
                v[1]*=-1
                ax+=v[0]
                ay+=v[1]
                az+=v[2]
              })
              ax/=a.length
              ay/=a.length
              az/=a.length
              a.map(v=>{
                X=(v[0]-ax)*scale
                Y=(v[1]-ay)*scale
                Z=(v[2]-az)*scale
                R2(rl,pt,yw,0)
                v[0]=X
                v[1]=Y
                v[2]=Z
              })
              maxY=-6e6
              a.map(v=>{
                if(v[1]>maxY)maxY=v[1]
              })
              a.map(v=>{
                v[1]-=maxY-oY
                v[0]+=tx
                v[1]+=ty
                v[2]+=tz
              })

              b=[]
              data.split("\nf ").map(v=>{
                b=[...b, v.split("\n")[0]]
              })
              b.shift()
              b=b.map(v=>v.split(' '))
              b=b.map(v=>{
                v=v.map(q=>{
                  return +q.split('/')[0]
                })
                v=v.filter(q=>q)
                return v
              })
              
              res=[]
              b.map(v=>{
                e=[]
                v.map(q=>{
                  e=[...e, a[q-1]]
                })
                e = e.filter(q=>q)
                res=[...res, e]
              })
            })
            return res
          }

          geoSphere = (mx, my, mz, iBc, size) => {
            let collapse=0
            let B=Array(iBc).fill().map(v=>{
              X = Rn()-.5
              Y = Rn()-.5
              Z = Rn()-.5
              return  [X,Y,Z]
            })
            for(let m=200;m--;){
              B.map((v,i)=>{
                X = v[0]
                Y = v[1]
                Z = v[2]
                B.map((q,j)=>{
                  if(j!=i){
                    X2=q[0]
                    Y2=q[1]
                    Z2=q[2]
                    d=1+(Math.hypot(X-X2,Y-Y2,Z-Z2)*(3+iBc/40)*3)**4
                    X+=(X-X2)*99/d
                    Y+=(Y-Y2)*99/d
                    Z+=(Z-Z2)*99/d
                  }
                })
                d=Math.hypot(X,Y,Z)
                v[0]=X/d
                v[1]=Y/d
                v[2]=Z/d
                if(collapse){
                  d=25+Math.hypot(X,Y,Z)
                  v[0]=(X-X/d)/1.1
                  v[1]=(Y-Y/d)/1.1         
                  v[2]=(Z-Z/d)/1.1
                }
              })
            }
            mind = 6e6
            B.map((v,i)=>{
              X1 = v[0]
              Y1 = v[1]
              Z1 = v[2]
              B.map((q,j)=>{
                X2 = q[0]
                Y2 = q[1]
                Z2 = q[2]
                if(i!=j){
                  d = Math.hypot(a=X1-X2, b=Y1-Y2, e=Z1-Z2)
                  if(d<mind) mind = d
                }
              })
            })
            a = []
            B.map((v,i)=>{
              X1 = v[0]
              Y1 = v[1]
              Z1 = v[2]
              B.map((q,j)=>{
                X2 = q[0]
                Y2 = q[1]
                Z2 = q[2]
                if(i!=j){
                  d = Math.hypot(X1-X2, Y1-Y2, Z1-Z2)
                  if(d<mind*2){
                    if(!a.filter(q=>q[0]==X2&&q[1]==Y2&&q[2]==Z2&&q[3]==X1&&q[4]==Y1&&q[5]==Z1).length) a = [...a, [X1*size,Y1*size,Z1*size,X2*size,Y2*size,Z2*size]]
                  }
                }
              })
            })
            B.map(v=>{
              v[0]*=size
              v[1]*=size
              v[2]*=size
              v[0]+=mx
              v[1]+=my
              v[2]+=mz
            })
            return [mx, my, mz, size, B, a]
          }

          lineFaceI = (X1, Y1, Z1, X2, Y2, Z2, facet, autoFlipNormals=false, showNormals=false) => {
            let X_, Y_, Z_, d, m, l_,K,J,L,p
            let I_=(A,B,M,D,E,F,G,H)=>(K=((G-E)*(B-F)-(H-F)*(A-E))/(J=(H-F)*(M-A)-(G-E)*(D-B)))>=0&&K<=1&&(L=((M-A)*(B-F)-(D-B)*(A-E))/J)>=0&&L<=1?[A+K*(M-A),B+K*(D-B)]:0
            let Q_=()=>[c.width/2+X_/Z_*600,c.height/2+Y_/Z_*600]
            let R_ = (Rl,Pt,Yw,m)=>{
              let M=Math, A=M.atan2, H=M.hypot
              X_=S(p=A(X_,Y_)+Rl)*(d=H(X_,Y_)),Y_=C(p)*d,X_=S(p=A(X_,Z_)+Yw)*(d=H(X_,Z_)),Z_=C(p)*d,Y_=S(p=A(Y_,Z_)+Pt)*(d=H(Y_,Z_)),Z_=C(p)*d
              if(m){ X_+=oX,Y_+=oY,Z_+=oZ }
            }
            let rotSwitch = m =>{
              switch(m){
                case 0: R_(0,0,Math.PI/2); break
                case 1: R_(0,Math.PI/2,0); break
                case 2: R_(Math.PI/2,0,Math.PI/2); break
              }        
            }
            let ax = 0, ay = 0, az = 0
            facet.map(q_=>{ ax += q_[0], ay += q_[1], az += q_[2] })
            ax /= facet.length, ay /= facet.length, az /= facet.length
            let b1 = facet[2][0]-facet[1][0], b2 = facet[2][1]-facet[1][1], b3 = facet[2][2]-facet[1][2]
            let c1 = facet[1][0]-facet[0][0], c2 = facet[1][1]-facet[0][1], c3 = facet[1][2]-facet[0][2]
            let crs = [b2*c3-b3*c2,b3*c1-b1*c3,b1*c2-b2*c1]
            d = Math.hypot(...crs)+.001
            let nls = 1 //normal line length
            crs = crs.map(q=>q/d*nls)
            let X1_ = ax, Y1_ = ay, Z1_ = az
            let flip = 1
            if(autoFlipNormals){
              let d1_ = Math.hypot(X1_-X1,Y1_-Y1,Z1_-Z1)
              let d2_ = Math.hypot(X1-(ax + crs[0]/99),Y1-(ay + crs[1]/99),Z1-(az + crs[2]/99))
              flip = d2_>d1_?-1:1
            }
            let X2_ = ax + (crs[0]*=flip), Y2_ = ay + (crs[1]*=flip), Z2_ = az + (crs[2]*=flip)
            if(showNormals){
              x.beginPath()
              X_ = X1_, Y_ = Y1_, Z_ = Z1_
              R_(Rl,Pt,Yw,1)
              if(Z_>0) x.lineTo(...Q_())
              X_ = X2_, Y_ = Y2_, Z_ = Z2_
              R_(Rl,Pt,Yw,1)
              if(Z_>0) x.lineTo(...Q_())
              x.lineWidth = 5
              x.strokeStyle='#f004'
              x.stroke()
            }
            
            let p1_ = Math.atan2(X2_-X1_,Z2_-Z1_)
            let p2_ = -(Math.acos((Y2_-Y1_)/(Math.hypot(X2_-X1_,Y2_-Y1_,Z2_-Z1_)+.001))+Math.PI/2)
            let isc = false, iscs = [false,false,false]
            X_ = X1, Y_ = Y1, Z_ = Z1
            R_(0,-p2_,-p1_)
            let rx_ = X_, ry_ = Y_, rz_ = Z_
            for(let m=3;m--;){
              if(isc === false){
                X_ = rx_, Y_ = ry_, Z_ = rz_
                rotSwitch(m)
                X1_ = X_, Y1_ = Y_, Z1_ = Z_ = 5, X_ = X2, Y_ = Y2, Z_ = Z2
                R_(0,-p2_,-p1_)
                rotSwitch(m)
                X2_ = X_, Y2_ = Y_, Z2_ = Z_
                facet.map((q_,j_)=>{
                  if(isc === false){
                    let l = j_
                    X_ = facet[l][0], Y_ = facet[l][1], Z_ = facet[l][2]
                    R_(0,-p2_,-p1_)
                    rotSwitch(m)
                    let X3_=X_, Y3_=Y_, Z3_=Z_
                    l = (j_+1)%facet.length
                    X_ = facet[l][0], Y_ = facet[l][1], Z_ = facet[l][2]
                    R_(0,-p2_,-p1_)
                    rotSwitch(m)
                    let X4_ = X_, Y4_ = Y_, Z4_ = Z_
                    if(l_=I_(X1_,Y1_,X2_,Y2_,X3_,Y3_,X4_,Y4_)) iscs[m] = l_
                  }
                })
              }
            }
            if(iscs.filter(v=>v!==false).length==3){
              let iscx = iscs[1][0], iscy = iscs[0][1], iscz = iscs[0][0]
              let pointInPoly = true
              ax=0, ay=0, az=0
              facet.map((q_, j_)=>{ ax+=q_[0], ay+=q_[1], az+=q_[2] })
              ax/=facet.length, ay/=facet.length, az/=facet.length
              X_ = ax, Y_ = ay, Z_ = az
              R_(0,-p2_,-p1_)
              X1_ = X_, Y1_ = Y_, Z1_ = Z_
              X2_ = iscx, Y2_ = iscy, Z2_ = iscz
              facet.map((q_,j_)=>{
                if(pointInPoly){
                  let l = j_
                  X_ = facet[l][0], Y_ = facet[l][1], Z_ = facet[l][2]
                  R_(0,-p2_,-p1_)
                  let X3_ = X_, Y3_ = Y_, Z3_ = Z_
                  l = (j_+1)%facet.length
                  X_ = facet[l][0], Y_ = facet[l][1], Z_ = facet[l][2]
                  R_(0,-p2_,-p1_)
                  let X4_ = X_, Y4_ = Y_, Z4_ = Z_
                  if(I_(X1_,Y1_,X2_,Y2_,X3_,Y3_,X4_,Y4_)) pointInPoly = false
                }
              })
              if(pointInPoly){
                X_ = iscx, Y_ = iscy, Z_ = iscz
                R_(0,p2_,0)
                R_(0,0,p1_)
                isc = [[X_,Y_,Z_], [crs[0],crs[1],crs[2]]]
              }
            }
            return isc
          }
          
          TruncatedOctahedron = ls => {
            let shp = [], a = []
            mind = 6e6
            for(let i=6;i--;){
              X = S(p=Math.PI*2/6*i+Math.PI/6)*ls
              Y = C(p)*ls
              Z = 0
              if(Y<mind) mind = Y
              a = [...a, [X, Y, Z]]
            }
            let theta = .6154797086703867
            a.map(v=>{
              X = v[0]
              Y = v[1] - mind
              Z = v[2]
              R(0,theta,0)
              v[0] = X
              v[1] = Y
              v[2] = Z+1.5
            })
            b = JSON.parse(JSON.stringify(a)).map(v=>{
              v[1] *= -1
              return v
            })
            shp = [...shp, a, b]
            e = JSON.parse(JSON.stringify(shp)).map(v=>{
              v.map(q=>{
                X = q[0]
                Y = q[1]
                Z = q[2]
                R(0,0,Math.PI)
                q[0] = X
                q[1] = Y
                q[2] = Z
              })
              return v
            })
            shp = [...shp, ...e]
            e = JSON.parse(JSON.stringify(shp)).map(v=>{
              v.map(q=>{
                X = q[0]
                Y = q[1]
                Z = q[2]
                R(0,0,Math.PI/2)
                q[0] = X
                q[1] = Y
                q[2] = Z
              })
              return v
            })
            shp = [...shp, ...e]

            coords = [
              [[3,1],[4,3],[4,4],[3,2]],
              [[3,4],[3,3],[2,4],[6,2]],
              [[1,4],[0,3],[0,4],[4,2]],
              [[1,1],[1,2],[6,4],[7,3]],
              [[3,5],[7,5],[1,5],[3,0]],
              [[2,5],[6,5],[0,5],[4,5]]
            ]
            a = []
            coords.map(v=>{
              b = []
              v.map(q=>{
                X = shp[q[0]][q[1]][0]
                Y = shp[q[0]][q[1]][1]
                Z = shp[q[0]][q[1]][2]
                b = [...b, [X,Y,Z]]
              })
              a = [...a, b]
            })
            shp = [...shp, ...a]
            return shp.map(v=>{
              v.map(q=>{
                q[0]/=3
                q[1]/=3
                q[2]/=3
                q[0]*=ls
                q[1]*=ls
                q[2]*=ls
              })
              return v
            })
          }
          
          Cylinder = (rw,cl,ls1,ls2) => {
            let a = []
            for(let i=rw;i--;){
              let b = []
              for(let j=cl;j--;){
                X = S(p=Math.PI*2/cl*j) * ls1
                Y = (1/rw*i-.5)*ls2
                Z = C(p) * ls1
                b = [...b, [X,Y,Z]]
              }
              //a = [...a, b]
              for(let j=cl;j--;){
                b = []
                X = S(p=Math.PI*2/cl*j) * ls1
                Y = (1/rw*i-.5)*ls2
                Z = C(p) * ls1
                b = [...b, [X,Y,Z]]
                X = S(p=Math.PI*2/cl*(j+1)) * ls1
                Y = (1/rw*i-.5)*ls2
                Z = C(p) * ls1
                b = [...b, [X,Y,Z]]
                X = S(p=Math.PI*2/cl*(j+1)) * ls1
                Y = (1/rw*(i+1)-.5)*ls2
                Z = C(p) * ls1
                b = [...b, [X,Y,Z]]
                X = S(p=Math.PI*2/cl*j) * ls1
                Y = (1/rw*(i+1)-.5)*ls2
                Z = C(p) * ls1
                b = [...b, [X,Y,Z]]
                a = [...a, b]
              }
            }
            b = []
            for(let j=cl;j--;){
              X = S(p=Math.PI*2/cl*j) * ls1
              Y = ls2/2
              Z = C(p) * ls1
              b = [...b, [X,Y,Z]]
            }
            //a = [...a, b]
            return a
          }

          Tetrahedron = size => {
            ret = []
            a = []
            let h = size/1.4142/1.25
            for(i=3;i--;){
              X = S(p=Math.PI*2/3*i) * size/1.25
              Y = C(p) * size/1.25
              Z = h
              a = [...a, [X,Y,Z]]
            }
            ret = [...ret, a]
            for(j=3;j--;){
              a = []
              X = 0
              Y = 0
              Z = -h
              a = [...a, [X,Y,Z]]
              X = S(p=Math.PI*2/3*j) * size/1.25
              Y = C(p) * size/1.25
              Z = h
              a = [...a, [X,Y,Z]]
              X = S(p=Math.PI*2/3*(j+1)) * size/1.25
              Y = C(p) * size/1.25
              Z = h
              a = [...a, [X,Y,Z]]
              ret = [...ret, a]
            }
            ax=ay=az=ct=0
            ret.map(v=>{
              v.map(q=>{
                ax+=q[0]
                ay+=q[1]
                az+=q[2]
                ct++
              })
            })
            ax/=ct
            ay/=ct
            az/=ct
            ret.map(v=>{
              v.map(q=>{
                q[0]-=ax
                q[1]-=ay
                q[2]-=az
              })
            })
            return ret
          }

          Cube = size => {
            for(CB=[],j=6;j--;CB=[...CB,b])for(b=[],i=4;i--;)b=[...b,[(a=[S(p=Math.PI*2/4*i+Math.PI/4),C(p),2**.5/2])[j%3]*(l=j<3?size/1.5:-size/1.5),a[(j+1)%3]*l,a[(j+2)%3]*l]]
            return CB
          }
          
          Octahedron = size => {
            ret = []
            let h = size/1.25
            for(j=8;j--;){
              a = []
              X = 0
              Y = 0
              Z = h * (j<4?-1:1)
              a = [...a, [X,Y,Z]]
              X = S(p=Math.PI*2/4*j) * size/1.25
              Y = C(p) * size/1.25
              Z = 0
              a = [...a, [X,Y,Z]]
              X = S(p=Math.PI*2/4*(j+1)) * size/1.25
              Y = C(p) * size/1.25
              Z = 0
              a = [...a, [X,Y,Z]]
              ret = [...ret, a]
            }
            return ret      
          }
          
          Dodecahedron = size => {
            ret = []
            a = []
            mind = -6e6
            for(i=5;i--;){
              X=S(p=Math.PI*2/5*i + Math.PI/5)
              Y=C(p)
              Z=0
              if(Y>mind) mind=Y
              a = [...a, [X,Y,Z]]
            }
            a.map(v=>{
              X = v[0]
              Y = v[1]-=mind
              Z = v[2]
              R(0, .553573, 0)
              v[0] = X
              v[1] = Y
              v[2] = Z
            })
            b = JSON.parse(JSON.stringify(a))
            b.map(v=>{
              v[1] *= -1
            })
            ret = [...ret, a, b]
            mind = -6e6
            ret.map(v=>{
              v.map(q=>{
                X = q[0]
                Y = q[1]
                Z = q[2]
                if(Z>mind)mind = Z
              })
            })
            d1=Math.hypot(ret[0][0][0]-ret[0][1][0],ret[0][0][1]-ret[0][1][1],ret[0][0][2]-ret[0][1][2])
            ret.map(v=>{
              v.map(q=>{
                q[2]-=mind+d1/2
              })
            })
            b = JSON.parse(JSON.stringify(ret))
            b.map(v=>{
              v.map(q=>{
                q[2]*=-1
              })
            })
            ret = [...ret, ...b]
            b = JSON.parse(JSON.stringify(ret))
            b.map(v=>{
              v.map(q=>{
                X = q[0]
                Y = q[1]
                Z = q[2]
                R(0,0,Math.PI/2)
                R(0,Math.PI/2,0)
                q[0] = X
                q[1] = Y
                q[2] = Z
              })
            })
            e = JSON.parse(JSON.stringify(ret))
            e.map(v=>{
              v.map(q=>{
                X = q[0]
                Y = q[1]
                Z = q[2]
                R(0,0,Math.PI/2)
                R(Math.PI/2,0,0)
                q[0] = X
                q[1] = Y
                q[2] = Z
              })
            })
            ret = [...ret, ...b, ...e]
            ret.map(v=>{
              v.map(q=>{
                q[0] *= size/2
                q[1] *= size/2
                q[2] *= size/2
              })
            })
            return ret
          }
          
          Icosahedron = size => {
            ret = []
            let B = [
              [[0,3],[1,0],[2,2]],
              [[0,3],[1,0],[1,3]],
              [[0,3],[2,3],[1,3]],
              [[0,2],[2,1],[1,0]],
              [[0,2],[1,3],[1,0]],
              [[0,2],[1,3],[2,0]],
              [[0,3],[2,2],[0,0]],
              [[1,0],[2,2],[2,1]],
              [[1,1],[2,2],[2,1]],
              [[1,1],[2,2],[0,0]],
              [[1,1],[2,1],[0,1]],
              [[0,2],[2,1],[0,1]],
              [[2,0],[1,2],[2,3]],
              [[0,0],[0,3],[2,3]],
              [[1,3],[2,0],[2,3]],
              [[2,3],[0,0],[1,2]],
              [[1,2],[2,0],[0,1]],
              [[0,0],[1,2],[1,1]],
              [[0,1],[1,2],[1,1]],
              [[0,2],[2,0],[0,1]],
            ]
            for(p=[1,1],i=38;i--;)p=[...p,p[l=p.length-1]+p[l-1]]
            phi = p[l]/p[l-1]
            a = [
              [-phi,-1,0],
              [phi,-1,0],
              [phi,1,0],
              [-phi,1,0],
            ]
            for(j=3;j--;ret=[...ret, b])for(b=[],i=4;i--;) b = [...b, [a[i][j],a[i][(j+1)%3],a[i][(j+2)%3]]]
            ret.map(v=>{
              v.map(q=>{
                q[0]*=size/2.25
                q[1]*=size/2.25
                q[2]*=size/2.25
              })
            })
            cp = JSON.parse(JSON.stringify(ret))
            out=[]
            a = []
            B.map(v=>{
              idx1a = v[0][0]
              idx2a = v[1][0]
              idx3a = v[2][0]
              idx1b = v[0][1]
              idx2b = v[1][1]
              idx3b = v[2][1]
              a = [...a, [cp[idx1a][idx1b],cp[idx2a][idx2b],cp[idx3a][idx3b]]]
            })
            out = [...out, ...a]
            return out
          }
          
          stroke = (scol, fcol, lwo=1, od=true, oga=1) => {
            if(scol){
              x.closePath()
              if(od) x.globalAlpha = .2*oga
              x.strokeStyle = scol
              x.lineWidth = Math.min(1000,100*lwo/Z)
              if(od) x.stroke()
              x.lineWidth /= 4
              x.globalAlpha = 1*oga
              x.stroke()
            }
            if(fcol){
              x.globalAlpha = 1*oga
              x.fillStyle = fcol
              x.fill()
            }
          }
          
          subbed = (subs, size, sphereize, shape) => {
            for(let m=subs; m--;){
              base = shape
              shape = []
              base.map(v=>{
                l = 0
                X1 = v[l][0]
                Y1 = v[l][1]
                Z1 = v[l][2]
                l = 1
                X2 = v[l][0]
                Y2 = v[l][1]
                Z2 = v[l][2]
                l = 2
                X3 = v[l][0]
                Y3 = v[l][1]
                Z3 = v[l][2]
                if(v.length > 3){
                  l = 3
                  X4 = v[l][0]
                  Y4 = v[l][1]
                  Z4 = v[l][2]
                  if(v.length > 4){
                    l = 4
                    X5 = v[l][0]
                    Y5 = v[l][1]
                    Z5 = v[l][2]
                  }
                }
                mx1 = (X1+X2)/2
                my1 = (Y1+Y2)/2
                mz1 = (Z1+Z2)/2
                mx2 = (X2+X3)/2
                my2 = (Y2+Y3)/2
                mz2 = (Z2+Z3)/2
                a = []
                switch(v.length){
                  case 3:
                    mx3 = (X3+X1)/2
                    my3 = (Y3+Y1)/2
                    mz3 = (Z3+Z1)/2
                    X = X1, Y = Y1, Z = Z1, a = [...a, [X,Y,Z]]
                    X = mx1, Y = my1, Z = mz1, a = [...a, [X,Y,Z]]
                    X = mx3, Y = my3, Z = mz3, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = mx1, Y = my1, Z = mz1, a = [...a, [X,Y,Z]]
                    X = X2, Y = Y2, Z = Z2, a = [...a, [X,Y,Z]]
                    X = mx2, Y = my2, Z = mz2, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = mx3, Y = my3, Z = mz3, a = [...a, [X,Y,Z]]
                    X = mx2, Y = my2, Z = mz2, a = [...a, [X,Y,Z]]
                    X = X3, Y = Y3, Z = Z3, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = mx1, Y = my1, Z = mz1, a = [...a, [X,Y,Z]]
                    X = mx2, Y = my2, Z = mz2, a = [...a, [X,Y,Z]]
                    X = mx3, Y = my3, Z = mz3, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    break
                  case 4:
                    mx3 = (X3+X4)/2
                    my3 = (Y3+Y4)/2
                    mz3 = (Z3+Z4)/2
                    mx4 = (X4+X1)/2
                    my4 = (Y4+Y1)/2
                    mz4 = (Z4+Z1)/2
                    cx = (X1+X2+X3+X4)/4
                    cy = (Y1+Y2+Y3+Y4)/4
                    cz = (Z1+Z2+Z3+Z4)/4
                    X = X1, Y = Y1, Z = Z1, a = [...a, [X,Y,Z]]
                    X = mx1, Y = my1, Z = mz1, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    X = mx4, Y = my4, Z = mz4, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = mx1, Y = my1, Z = mz1, a = [...a, [X,Y,Z]]
                    X = X2, Y = Y2, Z = Z2, a = [...a, [X,Y,Z]]
                    X = mx2, Y = my2, Z = mz2, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    X = mx2, Y = my2, Z = mz2, a = [...a, [X,Y,Z]]
                    X = X3, Y = Y3, Z = Z3, a = [...a, [X,Y,Z]]
                    X = mx3, Y = my3, Z = mz3, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = mx4, Y = my4, Z = mz4, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    X = mx3, Y = my3, Z = mz3, a = [...a, [X,Y,Z]]
                    X = X4, Y = Y4, Z = Z4, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    break
                  case 5:
                    cx = (X1+X2+X3+X4+X5)/5
                    cy = (Y1+Y2+Y3+Y4+Y5)/5
                    cz = (Z1+Z2+Z3+Z4+Z5)/5
                    mx3 = (X3+X4)/2
                    my3 = (Y3+Y4)/2
                    mz3 = (Z3+Z4)/2
                    mx4 = (X4+X5)/2
                    my4 = (Y4+Y5)/2
                    mz4 = (Z4+Z5)/2
                    mx5 = (X5+X1)/2
                    my5 = (Y5+Y1)/2
                    mz5 = (Z5+Z1)/2
                    X = X1, Y = Y1, Z = Z1, a = [...a, [X,Y,Z]]
                    X = X2, Y = Y2, Z = Z2, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = X2, Y = Y2, Z = Z2, a = [...a, [X,Y,Z]]
                    X = X3, Y = Y3, Z = Z3, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = X3, Y = Y3, Z = Z3, a = [...a, [X,Y,Z]]
                    X = X4, Y = Y4, Z = Z4, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = X4, Y = Y4, Z = Z4, a = [...a, [X,Y,Z]]
                    X = X5, Y = Y5, Z = Z5, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    X = X5, Y = Y5, Z = Z5, a = [...a, [X,Y,Z]]
                    X = X1, Y = Y1, Z = Z1, a = [...a, [X,Y,Z]]
                    X = cx, Y = cy, Z = cz, a = [...a, [X,Y,Z]]
                    shape = [...shape, a]
                    a = []
                    break
                }
              })
            }
            if(sphereize){
              ip1 = sphereize
              ip2 = 1-sphereize
              shape = shape.map(v=>{
                v = v.map(q=>{
                  X = q[0]
                  Y = q[1]
                  Z = q[2]
                  d = Math.hypot(X,Y,Z)
                  X /= d
                  Y /= d
                  Z /= d
                  X *= size*.75*ip1 + d*ip2
                  Y *= size*.75*ip1 + d*ip2
                  Z *= size*.75*ip1 + d*ip2
                  return [X,Y,Z]
                })
                return v
              })
            }
            return shape
          }
          
          subDividedIcosahedron  = (size, subs, sphereize = 0) => subbed(subs, size, sphereize, Icosahedron(size))
          subDividedTetrahedron  = (size, subs, sphereize = 0) => subbed(subs, size, sphereize, Tetrahedron(size))
          subDividedOctahedron   = (size, subs, sphereize = 0) => subbed(subs, size, sphereize, Octahedron(size))
          subDividedCube         = (size, subs, sphereize = 0) => subbed(subs, size, sphereize, Cube(size))
          subDividedDodecahedron = (size, subs, sphereize = 0) => subbed(subs, size, sphereize, Dodecahedron(size))
          
          Rn = Math.random
          
          LsystemRecurse = (size, splits, p1, p2, stem, theta, LsystemReduction, twistFactor) => {
            if(size < .25) return
            let X1 = stem[0]
            let Y1 = stem[1]
            let Z1 = stem[2]
            let X2 = stem[3]
            let Y2 = stem[4]
            let Z2 = stem[5]
            let p1a = Math.atan2(X2-X1,Z2-Z1)
            let p2a = -Math.acos((Y2-Y1)/(Math.hypot(X2-X1,Y2-Y1,Z2-Z1)+.0001))+Math.PI
            size/=LsystemReduction
            for(let i=splits;i--;){
              X = 0
              Y = -size
              Z = 0
              R(0, theta, 0)
              R(0, 0, Math.PI*2/splits*i+twistFactor)
              R(0, p2a, 0)
              R(0, 0, p1a+twistFactor)
              X+=X2
              Y+=Y2
              Z+=Z2
              let newStem = [X2, Y2, Z2, X, Y, Z]
              Lshp = [...Lshp, newStem]
              LsystemRecurse(size, splits, p1+Math.PI*2/splits*i+twistFactor, p2+theta, newStem, theta, LsystemReduction, twistFactor)
            }
          }
          DrawLsystem = shp => {
            shp.map(v=>{
              x.beginPath()
              X = v[0]
              Y = v[1]
              Z = v[2]
              R(Rl,Pt,Yw,1)
              if(Z>0)x.lineTo(...Q())
              X = v[3]
              Y = v[4]
              Z = v[5]
              R(Rl,Pt,Yw,1)
              if(Z>0)x.lineTo(...Q())
              lwo = Math.hypot(v[0]-v[3],v[1]-v[4],v[2]-v[5])*4
              stroke('#0f82','',lwo)
            })
            
          }
          Lsystem = (size, splits, theta, LsystemReduction, twistFactor) => {
            Lshp = []
            stem = [0,0,0,0,-size,0]
            Lshp = [...Lshp, stem]
            LsystemRecurse(size, splits, 0, 0, stem, theta, LsystemReduction, twistFactor)
            Lshp.map(v=>{
              v[1]+=size*1.5
              v[4]+=size*1.5
            })
            return Lshp
          }
          
          Sphere = (ls, rw, cl) => {
            a = []
            ls/=1.25
            for(j = rw; j--;){
              for(i = cl; i--;){
                b = []
                X = S(p = Math.PI*2/cl*i) * S(q = Math.PI/rw*j) * ls
                Y = C(q) * ls
                Z = C(p) * S(q) * ls
                b = [...b, [X,Y,Z]]
                X = S(p = Math.PI*2/cl*(i+1)) * S(q = Math.PI/rw*j) * ls
                Y = C(q) * ls
                Z = C(p) * S(q) * ls
                b = [...b, [X,Y,Z]]
                X = S(p = Math.PI*2/cl*(i+1)) * S(q = Math.PI/rw*(j+1)) * ls
                Y = C(q) * ls
                Z = C(p) * S(q) * ls
                b = [...b, [X,Y,Z]]
                X = S(p = Math.PI*2/cl*i) * S(q = Math.PI/rw*(j+1)) * ls
                Y = C(q) * ls
                Z = C(p) * S(q) * ls
                b = [...b, [X,Y,Z]]
                a = [...a, b]
              }
            }
            return a
          }
          
          Torus = (rw, cl, ls1, ls2, parts=1, twists=0, part_spacing=1.5) => {
            let ret = [], tx=0, ty=0, tz=0, prl1 = 0, p2a = 0
            let tx1 = 0, ty1 = 0, tz1 = 0, prl2 = 0, p2b = 0, tx2 = 0, ty2 = 0, tz2 = 0
            for(let m=parts;m--;){
              avgs = Array(rw).fill().map(v=>[0,0,0])
              for(j=rw;j--;)for(let i = cl;i--;){
                if(parts>1){
                  ls3 = ls1*part_spacing
                  X = S(p=Math.PI*2/parts*m) * ls3
                  Y = C(p) * ls3
                  Z = 0
                  R(prl1 = Math.PI*2/rw*(j-1)*twists,0,0)
                  tx1 = X
                  ty1 = Y 
                  tz1 = Z
                  R(0, 0, Math.PI*2/rw*(j-1))
                  ax1 = X
                  ay1 = Y
                  az1 = Z
                  X = S(p=Math.PI*2/parts*m) * ls3
                  Y = C(p) * ls3
                  Z = 0
                  R(prl2 = Math.PI*2/rw*(j)*twists,0,0)
                  tx2 = X
                  ty2 = Y
                  tz2 = Z
                  R(0, 0, Math.PI*2/rw*j)
                  ax2 = X
                  ay2 = Y
                  az2 = Z
                  p1a = Math.atan2(ax2-ax1,az2-az1)
                  p2a = Math.PI/2+Math.acos((ay2-ay1)/(Math.hypot(ax2-ax1,ay2-ay1,az2-az1)+.001))

                  X = S(p=Math.PI*2/parts*m) * ls3
                  Y = C(p) * ls3
                  Z = 0
                  R(Math.PI*2/rw*(j)*twists,0,0)
                  tx1b = X
                  ty1b = Y
                  tz1b = Z
                  R(0, 0, Math.PI*2/rw*j)
                  ax1b = X
                  ay1b = Y
                  az1b = Z
                  X = S(p=Math.PI*2/parts*m) * ls3
                  Y = C(p) * ls3
                  Z = 0
                  R(Math.PI*2/rw*(j+1)*twists,0,0)
                  tx2b = X
                  ty2b = Y
                  tz2b = Z
                  R(0, 0, Math.PI*2/rw*(j+1))
                  ax2b = X
                  ay2b = Y
                  az2b = Z
                  p1b = Math.atan2(ax2b-ax1b,az2b-az1b)
                  p2b = Math.PI/2+Math.acos((ay2b-ay1b)/(Math.hypot(ax2b-ax1b,ay2b-ay1b,az2b-az1b)+.001))
                }
                a = []
                X = S(p=Math.PI*2/cl*i) * ls1
                Y = C(p) * ls1
                Z = 0
                //R(0,0,-p1a)
                R(prl1,p2a,0)
                X += ls2 + tx1, Y += ty1, Z += tz1
                R(0, 0, Math.PI*2/rw*j)
                a = [...a, [X,Y,Z]]
                X = S(p=Math.PI*2/cl*(i+1)) * ls1
                Y = C(p) * ls1
                Z = 0
                //R(0,0,-p1a)
                R(prl1,p2a,0)
                X += ls2 + tx1, Y += ty1, Z += tz1
                R(0, 0, Math.PI*2/rw*j)
                a = [...a, [X,Y,Z]]
                X = S(p=Math.PI*2/cl*(i+1)) * ls1
                Y = C(p) * ls1
                Z = 0
                //R(0,0,-p1b)
                R(prl2,p2b,0)
                X += ls2 + tx2, Y += ty2, Z += tz2
                R(0, 0, Math.PI*2/rw*(j+1))
                a = [...a, [X,Y,Z]]
                X = S(p=Math.PI*2/cl*i) * ls1
                Y = C(p) * ls1
                Z = 0
                //R(0,0,-p1b)
                R(prl2,p2b,0)
                X += ls2 + tx2, Y += ty2, Z += tz2
                R(0, 0, Math.PI*2/rw*(j+1))
                a = [...a, [X,Y,Z]]
                ret = [...ret, a]
              }
            }
            return ret
          }

          G_ = 100000, iSTc = 1e4
          ST = Array(iSTc).fill().map(v=>{
            X = (Rn()-.5)*G_
            Y = (Rn()-.5)*G_
            Z = (Rn()-.5)*G_
            return [X,Y,Z]
          })

          burst = new Image()
          burst.src = "burst.png"

          showstars = false


          cl = 7
          rw = 13
          sp = 1
          frame = Array(rw*cl).fill().map((v, i) => {
            X = ((i%cl)-cl/2+.5)*sp
            Y = ((i/cl|0)-rw/2+.5)*sp
            Z = 0
            return [X,Y,Z]
          })

          w = cl*sp-.5
          h = rw*sp-.5
          outerFrame = Array(4).fill().map((v, i) => {
            X = ((i%2)-2/2+.5)*w
            Y = ((i/2|0)-2/2+.5)*h
            Z = 0
            return [X,Y,Z]
          })
          
          puyosLoaded = false
          puyos = Array(5).fill().map((v,i) => {
            el = {img: new Image(), loaded: false}
            el.img.onload = () => {
              puyos[i].loaded = true
              if(puyos.filter(q=>q.loaded).length == 5) puyosLoaded = true
            }
            el.img.src = `puyo${String.fromCharCode(65+i)}.png`
            return el
          })

          movTestLeft = () => {
            if(!validB(testB2) || isOjama(testB2)) return
            let lx1,ly1,lx2,ly2,idx1,idx2,success=false
            if(testB2[0].length>1){
              lx1 = Math.round(testB2[0][0][0] - 6 * sp)
              ly1 = Math.round(testB2[0][0][1] + 5 * sp)
              lx2 = Math.round(testB2[0][1][0] - 6 * sp)
              ly2 = Math.round(testB2[0][1][1] + 5 * sp)
              idx1 = Math.round(ly1*6+lx1)
              idx2 = Math.round(ly2*6+lx2)
              if(lx1>lx2){
                tlx  = lx1, tly  = ly1, tidx = idx1
                lx1  = lx2, ly1  = ly2, idx1 = idx2
                lx2  = tlx, ly2  = tly, idx2 = tidx
              }
              if(lx1>0 && (idx1<0||testAR[idx1-1]==-1) && !(lx2==lx1-sp && ly2==ly1)) lx1=testB2[0][0][0] -= sp, success=true
              if(lx2>0 && (idx2<0||testAR[idx2-1]==-1) && !(lx1==lx2-sp && ly1==ly2)) testB2[0][1][0] -= sp, success=true
            }else{
              lx1 = Math.round(testB2[0][0][0] - 6 * sp)
              ly1 = Math.round(testB2[0][0][1] + 6 * sp)
              idx1 = Math.round(ly1*6+lx1)
              if(lx1>0 && (idx1<0||testAR[idx1-1]==-1)) testB2[0][0][0] -= sp, success=true
            }
            return success
          }
          
          movTestRight = () => {
            if(!validB(testB2) || isOjama(testB2)) return
            let lx1,ly1,lx2,ly2,idx1,idx2,success=false
            if(testB2[0].length>1){
              lx1 = Math.round(testB2[0][0][0] - 6 * sp)
              ly1 = Math.round(testB2[0][0][1] + 5 * sp)
              lx2 = Math.round(testB2[0][1][0] - 6 * sp)
              ly2 = Math.round(testB2[0][1][1] + 5 * sp)
              idx1 = Math.round(ly1*6+lx1)
              idx2 = Math.round(ly2*6+lx2)
              if(lx1<lx2){
                tlx  = lx1, tly  = ly1, tidx = idx1
                lx1  = lx2, ly1  = ly2, idx1 = idx2
                lx2  = tlx, ly2  = tly, idx2 = tidx
              }
              if(lx1<5 && (idx1<0||testAR[idx1+1]==-1) && !(lx2==lx1+sp && ly2==ly1)) lx1=testB2[0][0][0] += sp, success=true
              if(lx2<5 && (idx2<0||testAR[idx2+1]==-1) && !(lx1==lx2+sp && ly1==ly2)) testB2[0][1][0] += sp, success=true
            }else{
              lx1 = Math.round(testB2[0][0][0] - 6 * sp)
              ly1 = Math.round(testB2[0][0][1] + 6 * sp)
              idx1 = Math.round(ly1*6+lx1)
              if(lx1<5 && (idx1<0||testAR[idx1+1]==-1)) testB2[0][0][0] += sp, success=true
            }
            return success
          }

          tryTestRot = (lx, ly) => {
            let lx1, ly1, idx
            lx1 = Math.round(lx - 6 * sp)
            ly1 = Math.round(ly + 5 * sp)
            idx = Math.round(ly1*6+lx1)
            return lx1>-1 && lx1<6 && idx<72 && (idx<0 || testAR[idx]==-1)
          }
          
          rotTestRight = () => {
            if(!validB(testB2) || isOjama(testB2)) return
            let success=false, ml=false, mr=false
            if(testB2[0].length>1){
              cx1 = testB2[0][0][0]
              cy1 = testB2[0][0][1]
              cx2 = testB2[0][1][0]
              cy2 = testB2[0][1][1]
              
              lx1 = Math.round(cx1 - 6 * sp)
              lx2 = Math.round(cx2 - 6 * sp)
              if(lx1==lx2 && lx1==5 && cy2<cy1) ml=movTestLeft(), cx1--, cx2--
              if(lx1==lx2 && lx1==0 && cy2>cy1) mr=movTestRight(), cx1++, cx2++
              
              p = Math.atan2(cx2-cx1,cy2-cy1)-Math.PI/2
              tx = cx1 + S(p) * sp
              ty = cy1 + C(p) * sp
              if(!(tx==cx1&&ty==cy1) && (success=tryTestRot(tx,ty))){
                testB2[0][1][0] = cx1 + S(p) * sp
                testB2[0][1][1] = cy1 + C(p) * sp
              }
              if(!success && ml) movTestRight()
              if(!success && mr) movTestLeft()
            }
          }

          tryB2Rot = (lx, ly) => {
            let lx1, ly1, idx
            lx1 = Math.round(lx - 6 * sp)
            ly1 = Math.round(ly + 5 * sp)
            idx = Math.round(ly1*6+lx1)
            return lx1>-1 && lx1<6 && idx<72 && (idx<0 || P2[idx]==-1)
          }
          
          rotB2Right = () => {
            if(!validB(B2) || isOjama(B2)) return
            let success=false, ml=false, mr=false
            if(B2[0].length>1){
              cx1 = B2[0][0][0]
              cy1 = B2[0][0][1]
              cx2 = B2[0][1][0]
              cy2 = B2[0][1][1]
              
              lx1 = Math.round(cx1 - 6 * sp)
              lx2 = Math.round(cx2 - 6 * sp)
              if(lx1==lx2 && lx1==5 && cy2<cy1) ml=movB2Left(), cx1--, cx2--
              if(lx1==lx2 && lx1==0 && cy2>cy1) mr=movB2Right(), cx1++, cx2++
              
              p = Math.atan2(cx2-cx1,cy2-cy1)-Math.PI/2
              tx = cx1 + S(p) * sp
              ty = cy1 + C(p) * sp
              if(!(tx==cx1&&ty==cy1) && (success=tryB2Rot(tx,ty))){
                B2[0][1][0] = cx1 + S(p) * sp
                B2[0][1][1] = cy1 + C(p) * sp
              }
              if(!success && ml) movB2Right()
              if(!success && mr) movB2Left()
            }
          }

          tryRot = (lx, ly) => {
            let lx1, ly1, idx
            lx1 = Math.round(lx + 10 * sp)
            ly1 = Math.round(ly + 5 * sp)
            idx = Math.round(ly1*6+lx1)
            return lx1>-1 && lx1<6 && idx<72 && (idx<0 || P1[idx]==-1)
          }
          
          rotRight = () => {
            if(!validB(B1) || isOjama(B1)) return
            let success=false, ml=false, mr=false
            if(B1[0].length>1){
              cx1 = B1[0][0][0]
              cy1 = B1[0][0][1]
              cx2 = B1[0][1][0]
              cy2 = B1[0][1][1]
              
              lx1 = Math.round(cx1 + 10 * sp)
              lx2 = Math.round(cx2 + 10 * sp)
              if(lx1==lx2 && lx1==5 && cy2<cy1) ml=movLeft(), cx1--, cx2--
              if(lx1==lx2 && lx1==0 && cy2>cy1) mr=movRight(), cx1++, cx2++
              
              p = Math.atan2(cx2-cx1,cy2-cy1)-Math.PI/2
              tx = cx1 + S(p) * sp
              ty = cy1 + C(p) * sp
              if(!(tx==cx1&&ty==cy1) && (success=tryRot(tx,ty))){
                B1[0][1][0] = cx1 + S(p) * sp
                B1[0][1][1] = cy1 + C(p) * sp
              }
              if(!success && ml) movRight()
              if(!success && mr) movLeft()
            }
          }

          movB2Left = () => {
            if(!validB(B2) || isOjama(B2)) return
            let lx1,ly1,lx2,ly2,idx1,idx2,success=false
            if(B2[0].length>1){
              lx1 = Math.round(B2[0][0][0] - 6 * sp)
              ly1 = Math.round(B2[0][0][1] + 5 * sp)
              lx2 = Math.round(B2[0][1][0] - 6 * sp)
              ly2 = Math.round(B2[0][1][1] + 5 * sp)
              idx1 = Math.round(ly1*6+lx1)
              idx2 = Math.round(ly2*6+lx2)
              if(lx1>lx2){
                tlx  = lx1, tly  = ly1, tidx = idx1
                lx1  = lx2, ly1  = ly2, idx1 = idx2
                lx2  = tlx, ly2  = tly, idx2 = tidx
              }
              if(lx1>0 && (idx1<0||P2[idx1-1]==-1) && !(lx2==lx1-sp && ly2==ly1)) lx1=B2[0][0][0] -= sp, success=true
              if(lx2>0 && (idx2<0||P2[idx2-1]==-1) && !(lx1==lx2-sp && ly1==ly2)) B2[0][1][0] -= sp, success=true
            }else{
              lx1 = Math.round(B2[0][0][0] - 6 * sp)
              ly1 = Math.round(B2[0][0][1] + 6 * sp)
              idx1 = Math.round(ly1*6+lx1)
              if(lx1>0 && (idx1<0||P2[idx1-1]==-1)) B2[0][0][0] -= sp, success=true
            }
            return success
          }
          
          movB2Right = () => {
            if(!validB(B2) || isOjama(B2)) return
            let lx1,ly1,lx2,ly2,idx1,idx2,success=false
            if(B2[0].length>1){
              lx1 = Math.round(B2[0][0][0] - 6 * sp)
              ly1 = Math.round(B2[0][0][1] + 5 * sp)
              lx2 = Math.round(B2[0][1][0] - 6 * sp)
              ly2 = Math.round(B2[0][1][1] + 5 * sp)
              idx1 = Math.round(ly1*6+lx1)
              idx2 = Math.round(ly2*6+lx2)
              if(lx1<lx2){
                tlx  = lx1, tly  = ly1, tidx = idx1
                lx1  = lx2, ly1  = ly2, idx1 = idx2
                lx2  = tlx, ly2  = tly, idx2 = tidx
              }
              if(lx1<5 && (idx1<0||P2[idx1+1]==-1) && !(lx2==lx1+sp && ly2==ly1)) lx1=B2[0][0][0] += sp, success=true
              if(lx2<5 && (idx2<0||P2[idx2+1]==-1) && !(lx1==lx2+sp && ly1==ly2)) B2[0][1][0] += sp, success=true
            }else{
              lx1 = Math.round(B2[0][0][0] - 6 * sp)
              ly1 = Math.round(B2[0][0][1] + 6 * sp)
              idx1 = Math.round(ly1*6+lx1)
              if(lx1<5 && (idx1<0||P2[idx1+1]==-1)) B2[0][0][0] += sp, success=true
            }
            return success
          }
          
          movLeft = () => {
            if(!validB(B1) || isOjama(B1)) return
            let lx1,ly1,lx2,ly2,idx1,idx2,success=false
            if(B1[0].length>1){
              lx1 = Math.round(B1[0][0][0] + 10 * sp)
              ly1 = Math.round(B1[0][0][1] + 5 * sp)
              lx2 = Math.round(B1[0][1][0] + 10 * sp)
              ly2 = Math.round(B1[0][1][1] + 5 * sp)
              idx1 = Math.round(ly1*6+lx1)
              idx2 = Math.round(ly2*6+lx2)
              if(lx1>lx2){
                tlx  = lx1, tly  = ly1, tidx = idx1
                lx1  = lx2, ly1  = ly2, idx1 = idx2
                lx2  = tlx, ly2  = tly, idx2 = tidx
              }
              if(lx1>0 && (idx1<0||P1[idx1-1]==-1) && !(lx2==lx1-sp && ly2==ly1)) lx1=B1[0][0][0] -= sp, success=true
              if(lx2>0 && (idx2<0||P1[idx2-1]==-1) && !(lx1==lx2-sp && ly1==ly2)) B1[0][1][0] -= sp, success=true
            }else{
              lx1 = Math.round(B1[0][0][0] + 10 * sp)
              ly1 = Math.round(B1[0][0][1] + 6 * sp)
              idx1 = Math.round(ly1*6+lx1)
              if(lx1>0 && (idx1<0||P1[idx1-1]==-1)) B1[0][0][0] -= sp, success=true
            }
            return success
          }
          
          movRight = () => {
            if(!validB(B1) || isOjama(B1)) return
            let lx1,ly1,lx2,ly2,idx1,idx2,success=false
            if(B1[0].length>1){
              lx1 = Math.round(B1[0][0][0] + 10 * sp)
              ly1 = Math.round(B1[0][0][1] + 5 * sp)
              lx2 = Math.round(B1[0][1][0] + 10 * sp)
              ly2 = Math.round(B1[0][1][1] + 5 * sp)
              idx1 = Math.round(ly1*6+lx1)
              idx2 = Math.round(ly2*6+lx2)
              if(lx1<lx2){
                tlx  = lx1, tly  = ly1, tidx = idx1
                lx1  = lx2, ly1  = ly2, idx1 = idx2
                lx2  = tlx, ly2  = tly, idx2 = tidx
              }
              if(lx1<5 && (idx1<0||P1[idx1+1]==-1) && !(lx2==lx1+sp && ly2==ly1)) lx1=B1[0][0][0] += sp, success=true
              if(lx2<5 && (idx2<0||P1[idx2+1]==-1) && !(lx1==lx2+sp && ly1==ly2)) B1[0][1][0] += sp, success=true
            }else{
              lx1 = Math.round(B1[0][0][0] + 10 * sp)
              ly1 = Math.round(B1[0][0][1] + 6 * sp)
              idx1 = Math.round(ly1*6+lx1)
              if(lx1<5 && (idx1<0||P1[idx1+1]==-1)) B1[0][0][0] += sp, success=true
            }
            return success
          }
          
          c.onkeydown = e => {
            e.preventDefault()
            e.stopPropagation()
            keys[e.keyCode] = true
          }
          
          c.onkeyup = e => {
            e.preventDefault()
            e.stopPropagation()
            if(e.keyCode !=32 || !quickDrop) keys[e.keyCode] = false
            keyTimers[e.keyCode] = 0
          }
          
          doKeys = () => {
            if(deathTimer && deathTimer>t)return
            keys.map((key, idx) => {
              if(key && keyTimers[idx]<=t){
                if(!B1alive || !B2alive){
                  setTimeout(()=>{restart()},50)
                }else{
                  switch(idx){
                    case 37:
                      keyTimers[idx] = t + keyPressPolyfillTimer/2
                      movLeft()
                      break
                    case 32:
                      if(keys.filter(v=>v).length == 1){
                        keyTimers[idx] = t + keyPressPolyfillTimer/30
                        quickDrop = true
                        dropB1()
                      }else{
                        keys = Array(256).fill(false)
                      }
                      break
                    case 38:
                      keyTimers[idx] = t + keyPressPolyfillTimer
                      rotRight()
                      break
                    case 39:
                      keyTimers[idx] = t + keyPressPolyfillTimer/2
                      movRight()
                      break
                    case 40:
                      keyTimers[idx] = t + keyPressPolyfillTimer/4
                      if(!isOjama(B1)) dropB1()
                      break
                  }
                }
              }
            })
          }
          
          genPiece = side => {
            if(!side){
              if(deathTimer) return
              if(P1[1]!=-1 || P1[2]!=-1 || P1[3]!=-1 || P1[4]!=-1){
                B1alive = false
                deathTimer = t + 2
                if(gameInPlay) score2++
                gameInPlay = false
                return
              }
              B1pieceQueued = false
            }else{
              if(P2[1]!=-1 || P2[2]!=-1 || P2[3]!=-1 || P2[4]!=-1){
                B2alive = false
                if(gameInPlay) score1++
                gameInPlay = false
                return
              }
              B2pieceQueued = false
            }
            let ofx = (sp * 8 + sp/2) * (side ? 1 : -1)
            let ofy = sp/2 - sp * 9
            let ofx2 = ofy2 = 0
            if(side && P2Ojama){
              newPiece = Array(P2Ojama).fill().map((v, i) => {
                ofx2+=1+(Rn()*2|0)
                if(ofx2>5) ofy2--
                ofx2%=6
                X = 0 + ofx - ofx2 + 3
                Y = -i + ofy + ofy2
                Z = 0
                id = 4
                return [X, Y, Z, id, X, Y, Z, 1]
              })
              P2Ojama = 0
            }else if(!side && P1Ojama){
              newPiece = Array(P1Ojama).fill().map((v, i) => {
                ofx2+=1+(Rn()*2|0)
                if(ofx2>5) ofy2--
                ofx2%=6
                X = 0 + ofx + ofx2 - 2
                Y = -i + ofy + ofy2
                Z = 0
                id = 4
                return [X, Y, Z, id, X, Y, Z, 1]
              })
              P1Ojama = 0
            }else{
              ofx = (sp * 8 + sp/2) * (side ? 1 : -1) -1 + (Rn()*4|0)
              newPiece = Array(2).fill().map((v, i) => {
                X = 0 + ofx
                Y = (i?-1:0) + ofy
                Z = 0
                id = Rn()*4|0
                return [X, Y, Z, id, X, Y, Z, 1]
              })
            }
            return newPiece
          }
          
          PlayerInit = idx => { // called initially & when a player dies
            Players[idx].score1         = score1
            Players[idx].score2         = score2
            Players[idx].totalPcs1      = totalPcs1
            Players[idx].totalPcs2      = totalPcs2
            Players[idx].P1Ojama        = P1Ojama
            Players[idx].P2Ojama        = P2Ojama
            Players[idx].B1alive        = B1alive
            Players[idx].B2alive        = B2alive
            //Players[idx].gameInPlay     = gameInPlay
            Players[idx].spawnSparksCmd = spawnSparksCmd
            Players[idx].B1             = B1
            Players[idx].P1             = P1
            Players[idx].B2             = []
            Players[idx].P2             = []
          }


          addPlayers = playerData => {
            PlayerLs = 1
            playerData.score = 0
            Players = [...Players, {playerData}]
            PlayerCount++
            PlayerInit(Players.length-1)
          }

          masterInit = () => {
            showBoxIds                 = true
            spawnSparksCmd             = []
            PlayerCount                = 0
            Players                    = []
            mx                         = 0
            my                         = 0
            score1                     = 0
            score2                     = 0
            totalPcs1                  = 0
            sliders                    = []
            player1Name                = playerName
            player2Name                = users.filter(v=>v.id!=userID)[0].name
            totalPcs2                  = 0
            AISpeed                    = 70 // 0-100...
            B1rensaTally               = 0
            B2rensaTally               = 0
            B1rensaChainLength         = 0
            B2rensaChainLength         = 0
            testCount                  = 0
            AIMoveSelected             = false
            B1                         = []
            B2                         = []
            sparks                     = []
            keys                       = Array(256).fill(false)
            keyTimers                  = Array(256).fill(0)
            B1RensaChainInProgress     = false
            B2RensaChainInProgress     = false
            B1RensaOffsets             = Array(6*14).fill(0)
            B2RensaOffsets             = Array(6*14).fill(0)
            quickDrop                  = false
            pieceQueued                = false
            B2pieceQueued              = false
            testB2RensaChainInProgress = false
            testB2pieceQueued          = false
            testB2alive                = true
            B1alive                    = true
            B2alive                    = true
            deathTimer                 = 0
            P1Ojama                    = 0
            P2Ojama                    = 0
            P1                         = Array(6*14).fill(-1)
            P2                         = Array(6*14).fill(-1)
            gameInPlay                 = true
            dropFreqMod                = 50 // 0-100...
            dropFreq                   = 5+60-60*(dropFreqMod/100)|0
            keyPressPolyfillTimer      = 1/60*10
          }
          masterInit()

          recurse = (side, idx, id, depth) => {
            if(id==4) return
            if(memo.indexOf(idx) != -1 || idx < 0 || idx > 71 || (side?P2:P1)[idx]==-1) return
            memo = [...memo, idx]
            if((side?P2:P1)[idx] == id) {
              count++
              cull = [...cull, idx]
              X = idx%6
              Y = idx/6|0
              let lidx = X>0?Y*6+X-1:-1
              let uidx = Y>0?(Y-1)*6+X:-1
              let ridx = X<5?Y*6+X+1:-1
              let didx = Y<11?(Y+1)*6+X:-1
              recurse(side, lidx, id, depth+1)
              recurse(side, uidx, id, depth+1)
              recurse(side, ridx, id, depth+1)
              recurse(side, didx, id, depth+1)
            }
          }
          
          testRecurse = (idx, id, depth) => {
            if(id==4) return
            if(memo.indexOf(idx) != -1 || idx < 0 || idx > 71 || testAR[idx]==-1) return
            memo = [...memo, idx]
            if(testAR[idx] == id) {
              testCount++
              cull = [...cull, idx]
              X = idx%6
              Y = idx/6|0
              let lidx = X>0?Y*6+X-1:-1
              let uidx = Y>0?(Y-1)*6+X:-1
              let ridx = X<5?Y*6+X+1:-1
              let didx = Y<11?(Y+1)*6+X:-1
              testRecurse(lidx, id, depth+1)
              testRecurse(uidx, id, depth+1)
              testRecurse(ridx, id, depth+1)
              testRecurse(didx, id, depth+1)
            }
          }

          spawnSparks = (X,Y,Z, pushToRemote = true) => {
            if(pushToRemote) spawnSparksCmd = [...spawnSparksCmd, [X,Y,Z]]
            let p, q
            for(let m=20;m--;){
              let vel = Rn()**.5/9
              let vx = S(p=Math.PI*2*Rn()) * S(q=Rn()<.5?Math.PI*Rn()**.5/2:Math.PI-Math.PI*Rn()**.5/2) * vel
              let vy = C(p) * S(q) * vel
              let vz = C(q) * vel
              sparks = [...sparks, [X,Y,Z,vx,vy,vz,1]]
            }
          }
          
          checkCompletion = side => {
            JSON.parse(JSON.stringify(side?P2:P1)).map((v,i) => {
              if(v!=-1) {
                cull = []
                memo = []
                count = 0
                recurse(side, i, v, 0)
                if(count>3){
                  if(side){
                    B2rensaChainLength++
                    totalPcs2 += cull.length
                    if(!B2RensaChainInProgress) {
                      B2rensaTally = Math.max(1, ((cull.length/2 * B2rensaChainLength) / 1 ) | 0)
                    }else{
                      B2rensaTally += Math.max(1, ((cull.length/2 * B2rensaChainLength) / 1 ) | 0)
                    }
                    B2RensaChainInProgress = true
                    P2 = P2.map((v,i) => {
                      return cull.indexOf(i) == -1 ? v : -1
                    })
                    JSON.parse(JSON.stringify(P2)).map((v,i) => {
                      if(cull.indexOf(i) != -1){
                        let X = i%6
                        let Y = i/6|0
                        let lidx = X>0?Y*6+X-1:-1
                        let uidx = Y>0?(Y-1)*6+X:-1
                        let ridx = X<5?Y*6+X+1:-1
                        let didx = Y<11?(Y+1)*6+X:-1
                        if(lidx!=-1 && lidx<72 && P2[lidx] == 4) P2[lidx] = -1
                        if(uidx!=-1 && uidx<72 && P2[uidx] == 4) P2[uidx] = -1
                        if(ridx!=-1 && ridx<72 && P2[ridx] == 4) P2[ridx] = -1
                        if(didx!=-1 && didx<72 && P2[didx] == 4) P2[didx] = -1
                        X += 8 * (side ? 1 : -1) - 2.5
                        Y -= 5.5
                        spawnSparks(X,Y,0)
                      }
                    })
                  }else{
                    B1rensaChainLength++
                    totalPcs1 += cull.length
                    if(!B1RensaChainInProgress) {
                      B1rensaTally = Math.max(1, ((cull.length/2 * B1rensaChainLength) / 1 ) | 0)
                    }else{
                      B1rensaTally += Math.max(1, ((cull.length/2 * B1rensaChainLength) / 1 ) | 0)
                    }
                    B1RensaChainInProgress = true
                    P1 = P1.map((v,i) => {
                      return cull.indexOf(i) == -1 ? v : -1
                    })
                    JSON.parse(JSON.stringify(P1)).map((v,i) => {
                      if(cull.indexOf(i) != -1){
                        let X = i%6
                        let Y = i/6|0
                        let lidx = X>0?Y*6+X-1:-1
                        let uidx = Y>0?(Y-1)*6+X:-1
                        let ridx = X<5?Y*6+X+1:-1
                        let didx = Y<11?(Y+1)*6+X:-1
                        if(lidx!=-1 && lidx<72 && P1[lidx] == 4) P1[lidx] = -1
                        if(uidx!=-1 && uidx<72 && P1[uidx] == 4) P1[uidx] = -1
                        if(ridx!=-1 && ridx<72 && P1[ridx] == 4) P1[ridx] = -1
                        if(didx!=-1 && didx<72 && P1[didx] == 4) P1[didx] = -1
                        X += 8 * (side ? 1 : -1) - 2.5
                        Y -= 5.5
                        spawnSparks(X,Y,0)
                      }
                    })
                  }
                  cull.map(v=>{
                    ofx = 8 * (side ? 1 : -1)
                    X = ((v%6)-2.5) * sp + ofx
                    Y = ((v/6|0)-5.5) * sp
                    Z = 0
                    spawnSparks(X,Y,Z)
                  })
                }
              }
            })
          }
          
          checkTestCompletion = () => {
            JSON.parse(JSON.stringify(testAR)).map((v,i) => {
              if(v!=-1) {
                cull = []
                memo = []
                testCount = 0
                testRecurse(i, v, 0)
                if(testCount>3){
                  testB2RensaChainInProgress = true
                  //testAR = testAR.map((v,i) => {
                  //  return cull.indexOf(i) == -1 ? v : -1
                  //})
                }
              }
            })
          }

          dropB1 = () => {
            if(!B1alive) return
            for(N=2;N--;){
              if(validB(B1)) B1.map(v=>{
                v.map(q=>{
                  lx = Math.round(q[0] + 10 * sp)
                  ly = Math.round(q[1] + 6 * sp)
                  idx = Math.round(ly*6+lx)
                  if(idx>0 && idx<72){
                    if(P1[idx]!=-1){
                      P1[idx-6]=q[3]
                      q[7]=0
                    }
                  }
                  if(idx>0 && idx>=72){
                    P1[idx-6]=q[3]
                    q[7]=0
                  }
                })
              })
            }
            B1 = B1.map(v=>{
              v = v.filter(q=>q[7])
              return v
            })
            B1 = B1.filter(v=>v.length)
            if(!B1.length && !B1pieceQueued) {
              checkCompletion(0)
              if(!B1RensaChainInProgress){
                B1pieceQueued = true
                quickDrop = keys[32] = false
                setTimeout(()=>{
                  B1 = [genPiece(0)]
                },100)
              }
            }
            if(B1.length && B1alive) {
              B1.map(v=>{
                v.map(q=>{
                  q[1]++
                })
              })
            }
          }
          
          dropB2 = () => {
            if(!B2alive) return
            for(N=2;N--;){
              if(validB(B2)) B2.map(v=>{
                v.map(q=>{
                  lx = Math.round(q[0] - 6 * sp)
                  ly = Math.round(q[1] + 6 * sp)
                  idx = Math.round(ly*6+lx)
                  if(idx>0 && idx<72){
                    if(P2[idx]!=-1){
                      P2[idx-6]=q[3]
                      q[7]=0
                    }
                  }
                  if(idx>0 && idx>=72){
                    P2[idx-6]=q[3]
                    q[7]=0
                  }
                })
              })
            }
            B2 = B2.map(v=>{
              v = v.filter(q=>q[7])
              return v
            })
            B2 = B2.filter(v=>v.length)
            if(!B2.length && !B2pieceQueued) {
              checkCompletion(1)
              if(!B2RensaChainInProgress){
                B2pieceQueued = true
                //quickDrop = keys[32] = false
                setTimeout(()=>{
                  B2 = [genPiece(1)]
                  AIMoveSelected = false
                },100)
              }
            }
            if(B2.length && B2alive) {
              B2.map(v=>{
                v.map(q=>{
                  q[1]++
                })
              })
            }
          }

          dropTestB2 = () => {
            if(!B2alive) return false
            let dropping = true
            for(let N=2;N--;){
              testB2.map(v=>{
                v.map(q=>{
                  lx = Math.round(q[0] - 6 * sp)
                  ly = Math.round(q[1] + 6 * sp)
                  idx = Math.round(ly*6+lx)
                  if(idx>0 && idx<72+6){
                    if(testAR[idx]!=-1){
                      testAR[idx-6]=q[3]
                      q[7]=0
                    }
                  }
                  if(idx>0 && idx>=72){
                    testAR[idx-6]=q[3]
                    q[7]=0
                  }
                })
              })
            }
            testB2 = testB2.map(v=>{
              v = v.filter(q=>q[7])
              return v
            })
            testB2 = testB2.filter(v=>v.length)
            if(!testB2.length){// && !testB2pieceQueued) {
              dropping = false
              checkTestCompletion(1)
              //if(!testB2RensaChainInProgress){
                //testB2pieceQueued = true
              //  setTimeout(()=>{
              //    testB2 = [genPiece(1)]
              //  },0)
              //}
            }
            if(testB2.length && testB2alive) {
              testB2.map(v=>{
                v.map(q=>{
                  q[1]++
                })
              })
            }
            return dropping
          }
          
          doLose = side => {
            for(let N=2;N--;){
              let m = side + 2
              ofx = (m+N)%2 ? -8:8
              cl_ = m<2 ? cl : 2;
              ct=0;
              outerFrame.map((v, i) => {
                if(i && i%cl_ && (i/cl_|0)){
                  x.beginPath()
                  l = i
                  X = f[l][0] + ofx
                  Y = f[l][1]
                  Z = f[l][2]
                  R(Rl,Pt,Yw,1)
                  if(Z>0) x.lineTo(...Q())
                  l = i-1
                  X = f[l][0] + ofx
                  Y = f[l][1]
                  Z = f[l][2]
                  R(Rl,Pt,Yw,1)
                  if(Z>0) x.lineTo(...Q())
                  l = i-1-cl_
                  X = f[l][0] + ofx
                  Y = f[l][1]
                  Z = f[l][2]
                  R(Rl,Pt,Yw,1)
                  if(Z>0) x.lineTo(...Q())
                  l = i-cl_
                  X = f[l][0] + ofx
                  Y = f[l][1]
                  Z = frame[l][2]
                  R(Rl,Pt,Yw,1)
                  if(Z>0){
                    l = Q()
                    x.lineTo(...l)
                    if(side==2){
                      col1 = '#ff06'
                      col2 = '#aa08'
                    }else{
                      col1 = N?'#0f06':'#f006'
                      col2 = N?'#0818':'#8018'
                    }
                    stroke(col1, col2, 4, true)
                  }
                  ct++
                }
              })
              X = ofx+.25
              Y = -1
              Z = 0
              R(Rl,Pt,Yw,1)
              if(Z>0){
                l = Q()
                if(side==2){
                  x.fillStyle = `hsla(${90},99%,${300+C(t*5+.25)*250}%,${.5+C(t*10)/2})`
                }else{
                  x.fillStyle = N?`hsla(${100},99%,${300+C(t*5+.25)*250}%,${.5+C(t*10)/2})`:`hsla(${0},99%,${300+C(t*5+.25)*250}%,${.5+C(t*10)/2})`
                }
                x.textAlign = 'center'
                x.font = (fs=800/Z)+'px Courier Prime'
                x.fillText(side==2?'TIE!':(N?'WIN!':'LOSE!'), l[0]-fs/4, l[1]-fs*2)
                x.fillText('GAME OVER', l[0]-fs/4, l[1])
                x.font = (fs=700/Z)+'px Courier Prime'
                x.fillStyle = `#fff`
                x.fillText('hit a key', l[0]-fs/4, l[1]+fs*2)
                x.font = (fs=600/Z)+'px Courier Prime'
                x.fillText('to continue', l[0]-fs/4, l[1]+fs*3.5)
              }
            }
          }

          restart = () => {
            setTimeout(()=>{
              quickDrop = false
              pieceQueued = false
              deathTimer = 0
              P1Ojama = 0
              P2Ojama = 0
              B1RensaChainInProgress = false
              B2RensaChainInProgress = false
              B1RensaOffsets = Array(6*14).fill(0)
              B2RensaOffsets = Array(6*14).fill(0)
              B1 = [genPiece(0)]
              //B2 = [genPiece(1)]
              B2 = []
              P1 = Array(6*14).fill(-1)
              P2 = Array(6*14).fill(-1)
              keys = Array(256).fill(false)
              keyTimers = Array(256).fill(0)
              gameInPlay = true
              B1alive = true
              B2alive = true
            }, 100)
          }

          beginGame = () => {
            B1 = [...B1, genPiece(0)]
            //B2 = [...B2, genPiece(1)]
            B2 = []
          }
          beginGame()
          
          rensaChainFoundVal = 20
          doAI = () => {
            if(!gameInPlay || !B2alive) return
            let dropping, tC
            if(validB(B2) && !isOjama(B2) && B2[0].length>1){
              ret = []
              for(let j = 4; j--;){
                for(let i=6;i--;){
                  scenarioScore = 0
                  testB2alive                = true
                  testB2RensaChainInProgress = false
                  tbr                        = false
                  testB2pieceQueued          = false
                  testB2 = JSON.parse(JSON.stringify(B2))
                  testAR = JSON.parse(JSON.stringify(P2))
                  ofx = Math.max(testB2[0][0][0]-5, testB2[0][1][0]-5)-.5
                  testB2[0][0][0]-=ofx
                  testB2[0][1][0]-=ofx
                  testB2[0][0][0]+=i
                  testB2[0][1][0]+=i
                  for(let m=j; m--;) rotTestRight()
                  tC=0
                  do{
                    if(dropping = dropTestB2()){
                      tC += testCount
                      vertIncentive = 0
                      if(testB2.length) testB2.map(v=>{
                        v.map(q=>{
                          vertIncentive += q[1]
                        })
                      })
                    }
                    if(testB2RensaChainInProgress) tbr = true
                  }while(dropping);
                  scenarioScore += tC
                  scenarioScore += vertIncentive
                  scenarioScore += cull.length*5
                  if(tbr) scenarioScore+=rensaChainFoundVal * cull.length
                  ret = [...ret, [scenarioScore, j, i, ofx, tC, cull.length*5, vertIncentive, tbr*cull.length]]
                }
              }
              let move = ret.sort((a,b)=>b[0]-a[0])[0]
              //console.log('testCount', move[4])
              //console.log('cull.length', move[5])
              //console.log('vertIncentive', move[6])
              //console.log('tbr', move[7])
              B2[0][0][0]-=move[3]
              B2[0][1][0]-=move[3]
              B2[0][0][0]+=move[2]
              B2[0][1][0]+=move[2]
              for(let m=move[1]; m--;) rotB2Right()
              
              AIMoveSelected = true
            }
          }
          
          isOjama = ar => {
            let ret = false
            ar.map(v=>{
              if(typeof v != 'undefined' && v != null){
                v.map(q=>{
                  if(q[3]==4) ret = true
                })
              }
            })
            return ret
          }
          
          validB = ar => {
            let ret = false
            if(typeof ar == 'object' && ar[0] != null){
              ret = true
              ar.map(v=>{
                if(typeof v == 'undefined') ret = false
              })
            }
            return ret
          }

          c.onmousedown = e => {
            let rect = c.getBoundingClientRect()
            mx = (e.pageX - rect.left)/c.clientWidth*c.width
            my = (e.pageY - rect.top)/c.clientHeight*c.height
            if(sliders.length){
              sliders.map(slider=>{
                X = slider.posX - slider.width/2 + slider.width/(slider.max - slider.min) * eval(slider.valVariable)
                Y = slider.posY
                s = slider.height/2
                d = Math.hypot(X-mx,Y-my)
                if(d<s && e.button == 0){
                  slider.sliding = true
                  slider.tmx = mx
                  slider.tmy = my
                }
              })
            }
          }
          
          c.onmouseup = e => {
            sliders.map(slider=>{
              slider.sliding = false
            })
          }
          
          c.onmousemove = e => {
            e.preventDefault()
            e.stopPropagation()
            let rect = c.getBoundingClientRect()
            mx = (e.pageX - rect.left)/c.clientWidth*c.width
            my = (e.pageY - rect.top)/c.clientHeight*c.height
            
            if(sliders.length){
              c.style.cursor = 'unset'
              sliders.map(slider=>{
                X = slider.posX - slider.width/2 + slider.width/(slider.max - slider.min) * eval(slider.valVariable)
                Y = slider.posY
                s = slider.height/2
                d = Math.hypot(X-mx,Y-my)
                if(d<s){
                  c.style.cursor = 'pointer'
                }
                if(slider.sliding){
                  if(slider.style == 'horizontal'){
                    dx = (mx-slider.tmx)/slider.width*(slider.max-slider.min)
                    eval(slider.valVariable + ' += dx')
                    slider.tmx = mx
                    slider.tmy = my
                    eval(slider.valVariable + ' = Math.min(slider.max,Math.max(slider.min,'+slider.valVariable+'))')
                    slider.captionVar = Math.round(eval(slider.valVariable)) + '%'
                    dropFreq = 5+60-60*(dropFreqMod/100)|0
                  }else{
                  }
                }
              })
            }
          }
          
          
          sliders = [...sliders,
            {
              caption: 'MY SPEED',
              style: 'horizontal',   // vertical/horizontal
              posX: c.width/2,
              posY: c.height-100,
              width: 400,
              height: 40,
              min: 0,
              max: 100,
              majorStep: 25,
              minorStep: 5,
              tickColor: '#0f8a',
              backgroundColor: '#40f4',
              selectorColor: '#fff',
              valVariable: 'dropFreqMod',
              padding: 75,
              textColor: '#f2a',
              fontSize: 32,
              captionVar: dropFreqMod + '%',
              sliding: false,
              tmx: 0,
              tmy: 0,
            }
          ]
          
          drawSlider = slider => {
            if(slider.style == 'horizontal'){
              x.fillStyle = slider.backgroundColor
              X = slider.posX - slider.width/2 - slider.padding/2
              Y = slider.posY - slider.height/2 - slider.padding/2
              w = slider.width + slider.padding
              h = slider.height + slider.padding
              x.fillRect(X,Y,w,h)
            }
            for(let i = slider.min; i<slider.max+1; i+=slider.minorStep){
              if(slider.style == 'horizontal'){
                x.beginPath()
                X = slider.posX - slider.width/2 + slider.width/(slider.max - slider.min) * i
                Y = slider.posY - slider.height/4
                x.lineTo(X,Y)
                X = slider.posX - slider.width/2 + slider.width/(slider.max - slider.min) * i
                Y = slider.posY + slider.height/4
                x.lineTo(X,Y)
                Z = 1
                stroke(slider.tickColor,'',.1, true)
              }else{
              }
            }
            for(let i = slider.min; i<slider.max+1; i+=slider.majorStep){
              if(slider.style == 'horizontal'){
                x.beginPath()
                X = slider.posX - slider.width/2 + slider.width/(slider.max - slider.min) * i
                Y = slider.posY - slider.height/2
                x.lineTo(X,Y)
                X = slider.posX - slider.width/2 + slider.width/(slider.max - slider.min) * i
                Y = slider.posY + slider.height/2
                x.lineTo(X,Y)
                Z = 1
                stroke(slider.tickColor,'',.1, true)
                x.fillStyle = slider.textColor
                x.textAlign = 'center'
                x.font = (slider.fontSize) + "px Courier Prime"
                x.fillText(i,X,Y+slider.height/2)
              }else{
              }
            }
            if(slider.style == 'horizontal'){
              x.beginPath()
              X = slider.posX - slider.width/2
              Y = slider.posY
              x.lineTo(X,Y)
              X = slider.posX + slider.width/2
              Y = slider.posY
              x.lineTo(X,Y)
              stroke(slider.tickColor,'',.1, true)
            }
            x.fillStyle = slider.textColor
            x.textAlign = 'left'
            x.font = (slider.fontSize*1.5) + "px Courier Prime"
            x.fillText(slider.caption + ' ' + slider.captionVar,slider.posX-slider.width/2,Y-slider.height/2-slider.fontSize/3)
            X = slider.posX - slider.width/2 + slider.width/(slider.max - slider.min) * eval(slider.valVariable)
            Y = slider.posY
            s = slider.height*1.5
            x.drawImage(burst,X-s/2,Y-s/2,s,s)
          }
        }
        
        oX=0, oY=0, oZ=10.5
        //Rl=0, Pt=S(t/4)/5, Yw=C(t/4)/5
        Rl=0, Pt=0, Yw=0
        
        x.globalAlpha = 1
        x.fillStyle='#101C'
        x.fillRect(0,0,c.width,c.height)
        x.lineJoin = x.lineCap = 'round'
        
        doKeys()
        
        if(showstars) ST.map(v=>{
          X = v[0]
          Y = v[1]
          Z = v[2]
          R(Rl,Pt,Yw,1)
          if(Z>0){
            if((x.globalAlpha = Math.min(1,(Z/5e3)**2))>.1){
              s = Math.min(1e3, 4e5/Z)
              x.fillStyle = '#ffffff04'
              l = Q()
              x.fillRect(l[0]-s/2,l[1]-s/2,s,s)
              s/=5
              x.fillStyle = '#fffa'
              x.fillRect(l[0]-s/2,l[1]-s/2,s,s)
            }
          }
        })

        x.globalAlpha = 1
        x.textAlign = 'center'
        for(m=0;m<4;m++) {
          ofx = m%2 ? -8:8
          cl_ = m<2 ? cl : 2;
          ct=0;
          (f=m<2?frame:outerFrame).map((v, i) => {
            if(i && i%cl_ && (i/cl_|0)){
              x.beginPath()
              l = i
              X = f[l][0] + ofx
              Y = f[l][1]
              Z = f[l][2]
              R(Rl,Pt,Yw,1)
              if(Z>0) x.lineTo(...Q())
              l = i-1
              X = f[l][0] + ofx
              Y = f[l][1]
              Z = f[l][2]
              R(Rl,Pt,Yw,1)
              if(Z>0) x.lineTo(...Q())
              l = i-1-cl_
              X = f[l][0] + ofx
              Y = f[l][1]
              Z = f[l][2]
              R(Rl,Pt,Yw,1)
              if(Z>0) x.lineTo(...Q())
              l = i-cl_
              X = f[l][0] + ofx
              Y = f[l][1]
              Z = frame[l][2]
              R(Rl,Pt,Yw,1)
              if(Z>0){
                l = Q()
                x.lineTo(...l)
                stroke(m<2 ? '#0af3' : '#f088', m<2?'#0af1':'', m<2?1.5:4, true)
                if(showBoxIds&&m<2){
                  x.fillStyle = '#fff4'
                  x.font = (fs=400/Z)+'px Courier Prime'
                  x.fillText(ct, l[0]-fs/1.2, l[1]+fs*1.25)
                }
              }
              ct++
            }
          })
        }

        X = 0
        Y = -6
        Z = 0
        R(Rl,Pt,Yw,1)
        x.font = (fs=1000/Z)+"px Courier Prime"
        x.fillStyle = '#fff'
        x.textAlign = 'center'
        l = Q()
        x.fillText('puyo puyo',l[0],l[1]+fs/2.5)

        X = -4
        Y = -4
        Z = 0
        R(Rl,Pt,Yw,1)
        x.font = (fs=640/Z)+"px Courier Prime"
        x.textAlign = 'left'
        l = Q()
        x.fillText('◄ '+player1Name,l[0],l[1]+fs/2.5+fs)
        x.fillText('games won: '+score1,l[0],l[1]+fs/2.5+fs*2)
        x.fillText('total pcs: '+totalPcs1,l[0],l[1]+fs/2.5+fs*3)

        X = 4
        Y = 1
        Z = 0
        R(Rl,Pt,Yw,1)
        x.textAlign = 'right'
        l = Q()
        x.fillText(player2Name + ' ►',l[0],l[1]+fs/2.5+fs)
        x.fillText('games won: '+score2,l[0],l[1]+fs/2.5+fs*2)
        x.fillText('total pcs: '+totalPcs2,l[0],l[1]+fs/2.5+fs*3)
        
        if(gameInPlay && !((t*60|0)%(dropFreq/8|0))) {
          if(isOjama(B1)) dropB1()
          if(isOjama(B2)) dropB2()
        }
        if(gameInPlay && !((t*60|0)%dropFreq)) {
          if(!keys[40])  dropB1()
          if(0) dropB2()
        }
        
        
        if(gameInPlay) for(let j=2;j--;){
          syncSpeed = !j?(isOjama(B2)?.5+AISpeed/200*3:.5+AISpeed/200):(isOjama(B1)?1:Math.max(.4,1/(1+dropFreq/10)*1.2)*((keys[32]&&j)?3.5:(keys[40]?1.75:keys[38]?1.5:1)))
          ar = j?B1:B2
          if(ar.filter(v=>v).length) ar.map((v,i) => {
            for(m=v.length;m--;){
              X1 = v[m][0]
              Y1 = v[m][1]
              Z1 = v[m][2]
              X2 = v[m][4]
              Y2 = v[m][5]
              Z2 = v[m][6]
              vx = X1-X2
              vy = Y1-Y2
              vz = Z1-Z2
              d1 = Math.hypot(vx,vy,vz)+.001
              d2 = Math.min(syncSpeed, d1)
              vx /= d1
              vy /= d1
              vz /= d1
              vx *= d2
              vy *= d2
              vz *= d2
              X = v[m][4] += vx * syncSpeed
              Y = v[m][5] += vy * syncSpeed
              Z = v[m][6] += vz * syncSpeed
              R(Rl,Pt,Yw,1)
              if(Z>0){
                s = 650/Z
                l = Q()
                x.drawImage(puyos[v[m][3]].img,l[0]-s/2,l[1]-s/2,s,s)
              }
            }
          })
        }
        
        cuml = 0
        grav = .1
        for(let j=2;j--;){
          let ofx = 8 * (j?1:-1)
          let ofy = 0, cuml=0;
          rcip = j?B2RensaChainInProgress:B1RensaChainInProgress;
          for(i=(n=JSON.parse(JSON.stringify(j?P2:P1))).length;i--;){
            v=n[i]
            if(i<72 && v!=-1){
              l = 0
              dropping = false
              if(i<72 && rcip){
                for(m=i+6;m<72;m+=6) if((j?P2:P1)[m]==-1) dropping = true
              }
              if(dropping){
                l=(j?B2RensaOffsets:B1RensaOffsets)[i]+=grav
                if(l>=sp){
                  (j?B2RensaOffsets:B1RensaOffsets)[i] = 0;
                  if(j){
                    P2[i] = -1
                    P2[i+6] = v
                  }else{
                    P1[i] = -1
                    P1[i+6] = v
                  }
                }
              }else{
                if(j){
                  B2RensaOffsets[i] = 0
                }else{
                  B1RensaOffsets[i] = 0
                }
              }
              X = ((i%6)-2.5) * sp + ofx
              Y = ((i/6|0)-5.5) * sp + ofy + l
              Z = 0
              cuml += l
              R(Rl,Pt,Yw,1)
              if(Z>0){
                s = 650/Z
                l = Q()
                x.drawImage(puyos[v].img,l[0]-s/2,l[1]-s/2,s,s)
              }
            }
          }
          if(rcip){
            if(cuml<.1){
              if(j){
                B2RensaChainInProgress = false
                B2rensaChainLength = 0
                B2RensaOffsets = Array(6*14).fill(0)
                P1Ojama += B2rensaTally
              }else{
                B1RensaChainInProgress = false
                B1rensaChainLength = 0
                B1RensaOffsets = Array(6*14).fill(0)
                P2Ojama += B1rensaTally
              }
            }
          }
        }
        
        if(!B2alive && B1alive) doLose(0)
        if(!B1alive && B2alive) doLose(1)
        if(!B2alive && !B1alive) doLose(2)


        sparks = sparks.filter(v=>v[6]>0)
        sparks.map(v=>{
          X = v[0] += v[3]
          Y = v[1] += v[4]
          Z = v[2] += v[5]
          R(Rl,Pt,Yw,1)
          if(Z>0){
            l = Q()
            s = Math.min(1e3,2e3/Z*v[6])
            x.fillStyle = '#ff000005'
            x.fillRect(l[0]-s/2,l[1]-s/2,s,s)
            s/=3
            x.fillStyle = '#ff880020'
            x.fillRect(l[0]-s/2,l[1]-s/2,s,s)
            s/=3
            x.fillStyle = '#ffffffff'
            x.fillRect(l[0]-s/2,l[1]-s/2,s,s)
          }
          v[6]-=.05
        })
        
        if(0 && !AIMoveSelected) doAI()
        if(0 && gameInPlay && Rn()<AISpeed/100) dropB2()
        
        sliders.map(slider=>{
          drawSlider(slider)
        })
        
        t+=1/60
        requestAnimationFrame(Draw)
      }

      alphaToDec = val => {
        let pow=0
        let res=0
        let cur, mul
        while(val!=''){
          cur=val[val.length-1]
          val=val.substring(0,val.length-1)
          mul=cur.charCodeAt(0)<58?cur:cur.charCodeAt(0)-(cur.charCodeAt(0)>96?87:29)
          res+=mul*(62**pow)
          pow++
        }
        return res
      }

      regFrame = document.querySelector('#regFrame')
      launchModal = document.querySelector('#launchModal')
      launchStatus = document.querySelector('#launchStatus')
      gameLink = document.querySelector('#gameLink')

      launch = () => {
        let none = false
        if((none = typeof users == 'undefined') || users.length<2){
          alert("this game requires at least one other player to join!\n\nCurrent users joined: " + (none ? 0 : users.length))
          return
        }
        launchModal.style.display = 'none'
        launched = true
        Draw()
      }

      doJoined = jid => {
        regFrame.style.display = 'none'
        regFrame.src = ''
        userID = +jid
        sync()
      }

      fullSync = false
      individualPlayerData = {}
      syncPlayerData = users => {
        users.map((user, idx) => {
          if((typeof Players != 'undefined') &&
             (l=Players.filter(v=>v.playerData.id == user.id).length)){
            l[0] = user
            fullSync = true
          }else if(launched && t){
            addPlayers(user)
          }
        })
        
        if(launched){
          Players = Players.filter((v, i) => {
            if(!users.filter(q=>q.id==v.playerData.id).length){
              cams = cams.filter((cam, idx) => idx != i)
            }
            return users.filter(q=>q.id==v.playerData.id).length
          })
          iCamsc = Players.length
          Players.map((AI, idx) => {
            if(AI.playerData.id == userID){
              individualPlayerData['id'] = userID
              individualPlayerData['name'] = AI.playerData.name
              individualPlayerData['time'] = AI.playerData.time
              //if(typeof score != 'undefined') {
              //  AI.score = score
              //  AI.playerData.score = score
              //  individualPlayerData['score'] = score
              //}
              
              if(typeof B1 != 'undefined'){
                if(B1.length){
                  individualPlayerData['B1'] = B1
                }
              }
              if(typeof P1 != 'undefined'){
                if(P1.length){
                  individualPlayerData['P1'] = P1
                }
              }
              
              if(typeof P2Ojama != 'undefined') {
                individualPlayerData['P2Ojama'] = P2Ojama
                P2Ojama = 0
              }


              //if(typeof score1 != 'undefined') individualPlayerData['score1'] = score1
              if(typeof score2 != 'undefined') individualPlayerData['score2'] = score2
              if(typeof totalPcs1 != 'undefined') individualPlayerData['totalPcs1'] = totalPcs1
              if(typeof totalPcs2 != 'undefined') individualPlayerData['totalPcs2'] = totalPcs2

              if(typeof B1alive != 'undefined') individualPlayerData['B1alive'] = B1alive
              if(typeof spawnSparksCmd != 'undefined') {
                individualPlayerData['spawnSparksCmd'] = JSON.parse(JSON.stringify(spawnSparksCmd))
                spawnSparksCmd = []
              }
              //if(typeof gameInPlay != 'undefined') individualPlayerData['gameInPlay'] = gameInPlay
              
              //if(typeof moves != 'undefined') individualPlayerData['moves'] = moves
              //if(typeof lastWinnerWasOp != 'undefined' && lastWinnerWasOp != -1) individualPlayerData['lastWinnerWasOp'] = lastWinnerWasOp
            }else{
              if(AI.playerData?.id){
                el = users.filter(v=>+v.id == +AI.playerData.id)[0]
                Object.entries(AI).forEach(([key,val]) => {
                  switch(key){
                    
                    // straight mapping of incoming data <-> players

                    case 'score2': if(typeof el[key] != 'undefined') score1 = el[key]; break;
                    case 'totalPcs1': if(typeof el[key] != 'undefined') totalPcs2 = el[key]; break;
                    case 'B1':
                      if(typeof el[key] != 'undefined'){
                        console.log('b2', el[key])
                        cB2 = JSON.parse(JSON.stringify(B2))
                        B2 = el[key]
                        if(validB(B2)){
                          B2.map((n, m) => {
                            n.map((v, i) => {
                              if(typeof v != 'undefined' && v.length){
                                v[0] += 16
                                v[4] += 16
                                if(typeof cB2[m]    !== 'undefined' &&
                                   typeof cB2[m][i] !== 'undefined' && v[5]>=cB2[m][i][5]) {
                                     v[4] = cB2[m][i][4]
                                     v[5] = cB2[m][i][5]
                                     v[6] = cB2[m][i][6]
                                }
                              }
                            })
                          })
                        }
                      }
                    break;
                    case 'P1':
                      if(typeof el[key] != 'undefined'){
                        P2 = el[key]
                      }
                    break;
                    
                    case 'P2Ojama': if(typeof el[key] != 'undefined') P1Ojama += el[key]; break;
                    case 'B1alive': if(typeof el[key] != 'undefined') B2alive = el[key]; break;
                    //case 'gameInPlay': if(typeof el[key] != 'undefined') gameInPlay = el[key]; break;
                    case 'spawnSparksCmd': if(typeof el[key] != 'undefined') {
                      el[key].map(v=>{
                        v[0] += 16
                        spawnSparks(...v, 0)
                      })
                      break;
                    }
                    
                    //case 'lastWinnerWasOp': if(typeof el[key] != 'undefined' && el[key] != -1) lastWinnerWasOp = el[key]; break;
                    //case 'score':
                    //  if(typeof el[key] != 'undefined'){
                    //    AI[key] = +el[key]
                    //    AI.playerData[key] = +el[key]
                    //  }
                    //break;
                  }
                })
              }
            }
          })
          for(i=0;i<Players.length;i++) if(Players[i]?.playerData?.id == userID) ofidx = i
        }
      }

      recData              = []
      opIsX = true
      ofidx                = 0
      users                = []
      userID               = ''
      gameConnected        = false
      playerName           = ''
      sync = () => {
        let sendData = {
          gameID,
          userID,
          individualPlayerData,
          //collected: 0
        }
        fetch('sync.php',{
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(sendData),
        }).then(res=>res.json()).then(data=>{
          if(data[0]){
            console.log('lastWinnerWasOp', lastWinnerWasOp)
            recData = data[1]
            if(data[3] && userID != gmid){
              individualPlayerData = recData.players[data[3]]
            }
            users = []
            Object.entries(recData.players).forEach(([key,val]) => {
              val.id = key
              users = [...users, val]
            })
            
            syncPlayerData(users)
            
            if(userID) playerName = recData.players[data[3]]['name']
            if(data[2]){ //needs reg
              regFrame.style.display = 'block'
              regFrame.src = `reg.php?g=${gameSlug}&gmid=${gmid}` 
            }else{
              if(!gameConnected){
                setInterval(()=>{sync()}, pollFreq = 333)  //ms
                gameConnected = true
              }
              if(!launched){
                launchStatus.innerHTML = ''
                users.map(user=>{
                  launchStatus.innerHTML      += user.name
                  launchStatus.innerHTML      += ` joined...`
                  if(user.id == gmid){
                    launchStatus.innerHTML    += ` [game master]`
                  }
                  launchStatus.innerHTML      += `<br>`
                })
                launchStatus.innerHTML      += `<br>`.repeat(4)
                launchButton = document.createElement('button')
                launchButton.innerHTML = 'launch!'
                launchButton.className = 'buttons'
                launchButton.onclick = () =>{ launch() }
                launchStatus.appendChild(launchButton)
                if(gameLink.innerHTML == ''){
                  launchModal.style.display = 'block'
                  resultLink = document.createElement('div')
                  resultLink.className = 'resultLink'
                  if(pchoice){
                    resultLink.innerHTML = location.href.split(pchoice+userID).join('')
                  }else{
                    resultLink.innerHTML = location.href
                  }
                  gameLink.appendChild(resultLink)
                  copyButton = document.createElement('button')
                  copyButton.title = "copy link to clipboard"
                  copyButton.className = 'copyButton'
                  copyButton.onclick = () => { copy() }
                  gameLink.appendChild(copyButton)
                }
              }
            }
          }else{
            console.log(data)
            console.log('error! crap')
          }
        })
      }

      fullCopy = () => {
        launchButton = document.createElement('button')
        launchButton.innerHTML = 'launch!'
        launchButton.className = 'buttons'
        launchButton.onclick = () =>{ launch() }
        launchStatus.appendChild(launchButton)
        gameLink.innerHTML = ''
        launchModal.style.display = 'block'
        resultLink = document.createElement('div')
        resultLink.className = 'resultLink'
        if(location.href.indexOf('&p=')!=-1){
          resultLink.innerHTML = location.href.split('&p='+userID).join('')
        }else{
          resultLink.innerHTML = location.href
        }
        gameLink.appendChild(resultLink)
        copyButton = document.createElement('button')
        copyButton.className = 'copyButton'
        gameLink.appendChild(copyButton)
        copy()
        launchModal.style.display = 'none'
        setTimeout(()=>{
          mbutton = mbutton.map(v=>false)
        },0)
      }

      copy = () => {
        var range = document.createRange()
        range.selectNode(document.querySelectorAll('.resultLink')[0])
        window.getSelection().removeAllRanges()
        window.getSelection().addRange(range)
        document.execCommand("copy")
        window.getSelection().removeAllRanges()
        let el = document.querySelector('#copyConfirmation')
        el.style.display = 'block';
        el.style.opacity = 1
        reduceOpacity = () => {
          if(+el.style.opacity > 0){
            el.style.opacity -= .02 * (launched ? 4 : 1)
            if(+el.style.opacity<.1){
              el.style.opacity = 1
              el.style.display = 'none'
            }else{
              setTimeout(()=>{
                reduceOpacity()
              }, 10)
            }
          }
        }
        setTimeout(()=>{reduceOpacity()}, 250)
      }
      
      userID = launched = pchoice = false
      if(location.href.indexOf('gmid=') !== -1){
        href = location.href
        if(href.indexOf('?g=') !== -1) gameSlug = href.split('?g=')[1].split('&')[0]
        if(href.indexOf('&g=') !== -1) gameSlug = href.split('&g=')[1].split('&')[0]
        if(href.indexOf('?gmid=') !== -1) gmid = href.split('?gmid=')[1].split('&')[0]
        if(href.indexOf('&gmid=') !== -1) gmid = href.split('&gmid=')[1].split('&')[0]
        if(href.indexOf('?p=') !== -1) userID = href.split(pchoice='?p=')[1].split('&')[0]
        if(href.indexOf('&p=') !== -1) userID = href.split(pchoice='&p=')[1].split('&')[0]
        gameID = alphaToDec(gameSlug)
        if(gameID) sync(gameID)

        if(userID == gmid){
          turnID = 0
        }else{
          turnID = 1
        }
      }
      */
      
      
    </script>
  </body>
</html>
FILE;

file_put_contents('../battleracer/g/index.php', $file);

$file = <<<'FILE'
<?php
  function alphaToDec($val){
    $pow=0;
    $res=0;
    while($val!=""){
      $cur=$val[strlen($val)-1];
      $val=substr($val,0,strlen($val)-1);
      $mul=ord($cur)<58?$cur:ord($cur)-(ord($cur)>96?87:29);
      $res+=$mul*pow(62,$pow);
      $pow++;
    }
    return $res;
  }

  function decToAlpha($val){
    $alphabet="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $ret="";
    while($val){
      $r=floor($val/62);
      $frac=$val/62-$r;
      $ind=(int)round($frac*62);
      $ret=$alphabet[$ind].$ret;
      $val=$r;
    }
    return $ret==""?"0":$ret;
  }
  
  require_once('../db.php');
  require_once('../functions.php');
  $data = json_decode(file_get_contents('php://input'));
  $gameID = mysqli_real_escape_string($link, $data->{'gameID'});
  $userName = mysqli_real_escape_string($link, $data->{'userName'});
  $userID = mysqli_real_escape_string($link, $data->{'userID'});
  $gmid = mysqli_real_escape_string($link, $data->{'gmid'});

  $success = false;
  
  function process($checkExisting = false){
    global $link, $sql, $userName, $userID, $slug, $res;
    global $gameID, $success, $msg, $gmid, $gidx, $data;
    $sql = "SELECT data FROM battleracerGames WHERE id = $gidx";
    $res = mysqli_query($link, $sql);
    if(mysqli_num_rows($res)){
      $success = true;
      $row = mysqli_fetch_assoc($res);
      if($checkExisting){
        $data = json_decode($row['data']);
        //if(!isset($data->{'players'}->{$userID})) die();
        $msg = "re-joined game as: $userName, with slug: $slug (id=$gidx)";
      }else{
        $data = mysqli_real_escape_string($link, newUserJSON2($userName, $userID, json_decode($row['data'])));
        $sql = "UPDATE battleracerGames SET data = \"$data\" WHERE id = $gameID";
        mysqli_query($link, $sql);
        $msg = "joined game as: $userName, with slug: $slug (id=$gidx)";
      }
      $slug = decToAlpha($gidx);
      echo json_encode([$success, $slug, $msg, $gmid, $userID]);
    }else{
      echo json_encode([$success, 'fail', $sql]);
      die();
    }
  }
  
  if(isset($gameID) && $gameID){
    $gidx = $gameID;
    if($userID){
      $sql = "SELECT * FROM battleracerSession WHERE id = $userID";
      $res = mysqli_query($link, $sql);
      if(mysqli_num_rows($res)){
        process(true);
      }
    }else{
      $sanitizedName = mysqli_real_escape_string($link, $userName);
      $sql = "INSERT INTO battleracerSessions (name, data, gameID) VALUES(\"$sanitizedName\", \"[]\", $gidx)";
      mysqli_query($link, $sql);
      $userID = mysqli_insert_id($link);
      process(false);
    }
  }else{
    echo json_encode([$success, 'fail', $sql]);
    die();
  }
?>
FILE;

file_put_contents('../battleracer/g/joinGame.php', $file);

$file = <<<'FILE'
<?php
  require_once('../db.php');
  $uri = explode('gmid=', $_SERVER['REQUEST_URI']);
  if(sizeof($uri)>1){
    $gmid = explode('&', $uri[1])[0];
    $sql = "SELECT name FROM battleracerSessions WHERE id = $gmid";
    $res = mysqli_query($link, $sql);
    $gameMaster = '';
    if(mysqli_num_rows($res)){
      $row = mysqli_fetch_assoc($res);
      $gameMaster = $row['name'];
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <style>
      /* latin-ext */
      @font-face {
        font-family: 'Courier Prime';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/courierprime/v9/u-450q2lgwslOqpF_6gQ8kELaw9pWt_-.woff2) format('woff2');
        unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
      }
      /* latin */
      @font-face {
        font-family: 'Courier Prime';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/courierprime/v9/u-450q2lgwslOqpF_6gQ8kELawFpWg.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
      }
      body,html{
        background: #000;
        margin: 0;
        height: 100vh;
        overflow: hidden;
      }
      #c{
        background:#000;
        display: block;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
      }
      #c:focus{
        outline: none;
      }
    </style>
  </head>
  <body>
    <canvas id="c" tabindex=0></canvas>
    <script>
      c = document.querySelector('#c')
      c.width = 1920
      c.height = 1080
      x = c.getContext('2d')
      C = Math.cos
      S = Math.sin
      t = 0
      T = Math.tan

      rsz=window.onresize=()=>{
        setTimeout(()=>{
          if(document.body.clientWidth > document.body.clientHeight*1.77777778){
            c.style.height = '100vh'
            setTimeout(()=>c.style.width = c.clientHeight*1.77777778+'px',0)
          }else{
            c.style.width = '100vw'
            setTimeout(()=>c.style.height =     c.clientWidth/1.77777778 + 'px',0)
          }
        },0)
      }
      rsz()

      async function Draw(){
        oX=oY=oZ=0
        if(!t){
          HSVFromRGB = (R, G, B) => {
            let R_=R/256
            let G_=G/256
            let B_=B/256
            let Cmin = Math.min(R_,G_,B_)
            let Cmax = Math.max(R_,G_,B_)
            let val = Cmax //(Cmax+Cmin) / 2
            let delta = Cmax-Cmin
            let sat = Cmax ? delta / Cmax: 0
            let min=Math.min(R,G,B)
            let max=Math.max(R,G,B)
            let hue = 0
            if(delta){
              if(R>=G && R>=B) hue = (G-B)/(max-min)
              if(G>=R && G>=B) hue = 2+(B-R)/(max-min)
              if(B>=G && B>=R) hue = 4+(R-G)/(max-min)
            }
            hue*=60
            while(hue<0) hue+=360;
            while(hue>=360) hue-=360;
            return [hue, sat, val]
          }

          RGBFromHSV = (H, S, V) => {
            while(H<0) H+=360;
            while(H>=360) H-=360;
            let C = V*S
            let X = C * (1-Math.abs((H/60)%2-1))
            let m = V-C
            let R_, G_, B_
            if(H>=0 && H < 60)    R_=C, G_=X, B_=0
            if(H>=60 && H < 120)  R_=X, G_=C, B_=0
            if(H>=120 && H < 180) R_=0, G_=C, B_=X
            if(H>=180 && H < 240) R_=0, G_=X, B_=C
            if(H>=240 && H < 300) R_=X, G_=0, B_=C
            if(H>=300 && H < 360) R_=C, G_=0, B_=X
            let R = (R_+m)*256
            let G = (G_+m)*256
            let B = (B_+m)*256
            return [R,G,B]
          }
          
          R=R2=(Rl,Pt,Yw,m)=>{
            M=Math
            A=M.atan2
            H=M.hypot
            X=S(p=A(X,Z)+Yw)*(d=H(X,Z))
            Z=C(p)*d
            Y=S(p=A(Y,Z)+Pt)*(d=H(Y,Z))
            Z=C(p)*d
            X=S(p=A(X,Y)+Rl)*(d=H(X,Y))
            Y=C(p)*d
            if(m){
              X+=oX
              Y+=oY
              Z+=oZ
            }
          }
          Q=()=>[c.width/2+X/Z*700,c.height/2+Y/Z*700]
          I=(A,B,M,D,E,F,G,H)=>(K=((G-E)*(B-F)-(H-F)*(A-E))/(J=(H-F)*(M-A)-(G-E)*(D-B)))>=0&&K<=1&&(L=((M-A)*(B-F)-(D-B)*(A-E))/J)>=0&&L<=1?[A+K*(M-A),B+K*(D-B)]:0
          
          Rn = Math.random
          
          stroke = (scol, fcol, lwo=1, od=true, oga=1) => {
            if(scol){
              //x.closePath()
              if(od) x.globalAlpha = .2*oga
              x.strokeStyle = scol
              x.lineWidth = Math.min(1000,100*lwo/Z)
              if(od) x.stroke()
              x.lineWidth /= 4
              x.globalAlpha = 1*oga
              x.stroke()
            }
            if(fcol){
              x.globalAlpha = 1*oga
              x.fillStyle = fcol
              x.fill()
            }
          }

          burst = new Image()
          burst.src = "burst.png"
          
          starsLoaded = false, starImgs = [{loaded: false}]
          starImgs = Array(9).fill().map((v,i) => {
            let a = {img: new Image(), loaded: false}
            a.img.onload = () => {
              a.loaded = true
              setTimeout(()=>{
                if(starImgs.filter(v=>v.loaded).length == 9) starsLoaded = true
              }, 0)
            }
            a.img.src = `https://srmcgann.github.io/stars/star${i+1}.png`
            return a
          })
          
          splash = new Image()
          splash.src = '../splash.jpg'
          starfield = document.createElement('video')
          loaded = false
          starfield.oncanplay = () =>{
            starfield.play()
            loaded = true
          }
          starfield.loop = true
          starfield.muted = true
          starfield.src = 'https://srmcgann.github.io/orbs/compound-starfield.mp4'
          
          
          cursorPos = 0
          curInputLeft = curInputRight = ''
          mask = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-=_+`~\][|}{\'":;/.,?>< '
               
          mx = my = 0
          c.onmousemove = e => {
            e.preventDefault()
            e.stopPropagation()
            rect = c.getBoundingClientRect()
            mx = (e.pageX-rect.x)/c.clientWidth*c.width
            my = (e.pageY-rect.y)/c.clientHeight*c.height
          }
          
          cFocused = false
          c.onfocus = () => {
            cFocused = true
          }
          
          c.onblur = () => {
            cFocused = false
          }
          
          c.onmousedown = e => {
            c.focus()
            e.preventDefault()
            e.stopPropagation()
            if(e.button == 0){
              buttons.map(button=>{
                if(button.hover){
                  eval(button.callback + '()')
                }
              })
            }
          }

          c.onkeydown = e => {
            e.preventDefault()
            e.stopPropagation()
            switch (e.key){
              case 'Enter':
                if((curInputLeft + curInputRight) != ''){
                  join()
                }
              break
              case 'Backspace':
                curInputLeft = curInputLeft.substr(0, curInputLeft.length-1)
              break
              case 'Delete':
                curInputRight = curInputRight.substr(1)
              break
              case 'ArrowLeft':
                curInputRight = curInputLeft.substr(curInputLeft.length-1) + curInputRight
                curInputLeft = curInputLeft.substr(0, curInputLeft.length-1)
              break
              case 'ArrowUp':
              break
              case 'ArrowRight':
                curInputLeft = curInputLeft + curInputRight.substr(0,1)
                curInputRight = curInputRight.substr(1)
              break
              case 'ArrowDown':
              break
              default:
                curInputLeft += mask.indexOf(l=e.key) !== -1 ? l : ''
              break 
            }
          }
          
          c.focus()
          
          //globals
          userName = ''
          
          renderButton = (callback, X, Y, w, h, caption) => {
            tx = X
            ty = Y
            x.fillStyle = '#0f8d'
            x.fillRect(tx,ty,w,h)
            x.strokeStyle = '#0f84'
            x.lineWidth = 10
            x.strokeRect(X1=tx, Y1=ty, w, h)
            x.font = (fs = 50) + "px Courier Prime"
            x.fillStyle = '#0f8e'
            x.fillStyle = '#042f'
            x.fillText(caption, tx + 20, ty+=fs)
            
            X2=X1+w
            Y2=Y1+h
            if(mx>X1 && mx<X2 && my>Y1 && my<Y2){
              if(buttonsLoaded){
                buttons[bct].hover = true
              }else{
                buttons=[...buttons, {callback,X1,Y1,X2,Y2,hover:true}]
              }
              c.style.cursor = 'pointer'
            }else{
              if(buttonsLoaded){
                buttons[bct].hover = false
              }else{
                buttons=[...buttons, {callback,X1,Y1,X2,Y2,hover:false}]
              }
            }
            bct++
          }
          
          renderInput = (textVar, X, Y, w, h, placeholder, caption) => {
            tx = X
            ty = Y
            x.fillStyle = '#112c'
            x.fillRect(tx,ty,w,h)
            x.strokeStyle = '#2fa4'
            x.lineWidth = 10
            x.strokeRect(tx, ty, w, h)
            let fs
            x.font = (fs = 50) + "px Courier Prime"
            x.fillStyle = '#0f8a'
            x.fillText(caption, tx, ty-fs/2, w, h)
            x.fillStyle = eval(`${textVar} ? '#fff' : '#888'`) 
            eval(`x.fillText(${textVar} ? ${textVar} : placeholder, tx + 20, ty+=fs)`)
            eval(`${textVar} = curInputLeft + curInputRight`)
            if(showcursor && ((t*60|0)%30)<15){
              ofx = x.measureText(curInputLeft).width
              x.beginPath()
              x.lineTo(tx + ofx + fs/2, ty-fs/1.25)
              x.lineTo(tx + ofx + fs/2, ty-fs/1.25+fs)
              Z = 1
              stroke('#f00','',.25,true)
            }
          }
          buttonsLoaded = false
          buttons = []
        }
        
        oX=0, oY=0, oZ=16
        Rl=S(t/8)/3, Pt=0, Yw=0
        
        x.globalAlpha = 1
        x.fillStyle='#000'
        x.fillRect(0,0,c.width,c.height)
        x.lineJoin = x.lineCap = 'round'
        
        x.globalAlpha = 1

        if(loaded){
          showcursor = cFocused
          bct = 0
          x.globalAlpha = .6
          x.drawImage(splash,0,0,c.width,c.height)
          x.globalAlpha = 1
          x.fillStyle = '#02040844'
          x.fillRect(0,0,c.width,c.height)
          x.globalAlpha = .2
          x.drawImage(starfield,0,0,c.width,c.height)
          x.globalAlpha = 1
          
          w = c.width -100
          h = c.height -75
          x.fillStyle = '#2084'
          x.fillRect(c.width/2-w/2,c.height/2-h/2,w,h)
          x.strokeStyle = '#40f4'
          x.lineWidth = 20
          x.strokeRect(c.width/2-w/2,c.height/2-h/2,w,h)
          
          x.font = (fs = 55) + 'px Courier Prime'
          x.fillStyle = '#8fca'
          x.textAlign = 'left'
          ofy = 50
          x.fillText('"'+gameMaster+'" has challenged you to an online game of...', fs*2.5, ofy + fs*2)
          ofy += fs*8
          x.font = (fs = 200) + 'px Courier Prime'
          x.fillStyle = '#0f8c'
          x.fillText('BATTLERACER!', fs*2, ofy)
          x.font = (fs = 55) + 'px Courier Prime'
          x.fillStyle = '#8fca'

          ofy += fs*1.5
          renderInput('userName', fs*4, ofy + fs*1.25, 800, 70, 'name', 'enter your name')
          
          ofy += fs*1.5
          renderButton('join', fs*4, ofy + fs*1.25, 375, 70, ' join game')
          buttonsLoaded = true
        }

        t+=1/60
        requestAnimationFrame(Draw)
      }
      

      userName = ''
      gameConnected = false
      
      gameMaster = '<?php echo $gameMaster; ?>'
      join = () => {
        let sendData = {
          gameID,
          userName,
          gmid,
          userID: top.userID ? top.userID : ''
        }
        fetch('joinGame.php',{
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(sendData),
        }).then(res=>res.json()).then(data=>{
          if(data[0]){
            console.log(data)
            if(data[1] != 'fail'){
              console.log(data[2]) //msg
              href = top.window.location.href
              if(href.indexOf('?p=') == -1 && href.indexOf('&p=') == -1){
                top.history.pushState({},null, href + "&p=" + data[4])
              }
              top.doJoined(data[4])
            }else{
              console.log('error! game ID not found!')
            }
          }else{
            console.log('error! crap')
          }
        })
      }

      Draw()

      alphaToDec = val => {
        let pow=0
        let res=0
        let cur, mul
        while(val!=''){
          cur=val[val.length-1]
          val=val.substring(0,val.length-1)
          mul=cur.charCodeAt(0)<58?cur:cur.charCodeAt(0)-(cur.charCodeAt(0)>96?87:29)
          res+=mul*(62**pow)
          pow++
        }
        return res
      }

      gameID = ''
      gmid = ''
      if(location.href.indexOf('?g=') !== -1){
        gameSlug = location.href.split('?g=')[1].split('&')[0]
        gmid = location.href.split('gmid=')[1].split('&')[0]
        console.log('[reg] game slug: ' + gameSlug)
        gameID = alphaToDec(gameSlug)
        console.log('[reg]       (id: ' + gameID + ')')
        if(top.href.indexOf('?p=') !== -1) userID = top.href.split(pchoice='?p=')[1].split('&')[0]
        if(top.href.indexOf('&p=') !== -1) userID = top.href.split(pchoice='&p=')[1].split('&')[0]
      }
    </script>
  </body>
</html>
FILE;

file_put_contents('../battleracer/g/reg.php', $file);

$file = <<<'FILE'
<?php
  require_once('../db.php');
  $data = json_decode(file_get_contents('php://input'));
  $gameID = mysqli_real_escape_string($link, $data->{'gameID'});
  $userID = mysqli_real_escape_string($link, $data->{'userID'});
  //$collected = $data->{'collected'};
  $individualPlayerData = $data->{'individualPlayerData'};
  
  $igt = gettype($individualPlayerData);
  $has = false;
  switch($igt){
    case 'array':
      $has = array_key_exists('name', $individualPlayerData);
    break;
    case 'object':
      $has = property_exists($individualPlayerData, 'name');
    break;
  }
  
  $success = false;

  $sql = "SELECT unix_timestamp()";
  $res = mysqli_query($link, $sql);
  $row = mysqli_fetch_assoc($res);
  $time = $row['unix_timestamp()'];

  $sql = "SELECT * FROM battleracerGames WHERE id = $gameID";
  $res = mysqli_query($link, $sql);

  $data = '';
  $newData = '';
  $needsReg = false;
  if(mysqli_num_rows($res)){
    $success = true;
    $row = mysqli_fetch_assoc($res);
    $data = json_decode($row['data']);
    /*
    $colSize = sizeof($collected);
    $existingSize = sizeof($data->{'collected'});
    $maxSize = max($colSize, $existingSize);
    $newCol = [];
    for($i = 0; $i<$maxSize; $i++){
      if(
        ($i < $colSize && $collected[$i] === '1') ||
        ($i < $existingSize && $data->{'collected'} === '1')
      ){
        $newCol[]= '1';
      }else{
        $newCol[]= '0';
      }
    }
    $data->{'collected'} = $newCol;
    */
    forEach($data->{'players'} as $key=>$player){
      // player drops if unseen for 10 seconds
      if(isset($player->{'time'}) && ($time - $player->{'time'} > 10)){
        unset($data->{'players'}->{$key});
      }
    }
    if($userID){
      if($has){
        if($time - $individualPlayerData->{'time'} < 60){ // player may reconnect for up to a minute
          $individualPlayerData->{'time'} = $time;
          $data->{'players'}->{$userID} = (object)$individualPlayerData;
        }
      }
      if($userID && $data->{'players'}->{$userID}){
        if($has){
          forEach($individualPlayerData as $key=>$val){
            $data->{'players'}->{$userID}->{$key} = $val;
          }
        }
        $data->{'players'}->{$userID}->{'time'} = $time;
        $newData = mysqli_real_escape_string($link, json_encode($data));
        $sql = "UPDATE battleracerGames SET data = \"$newData\" WHERE id = $gameID";
        mysqli_query($link, $sql);
        $needsReg = false;
      }else{
        $e = 1;
        $needsReg = true;
      }
    }else{
      $e = 2;
      $needsReg = true;
    }
  }

  echo json_encode([$success, $data, $needsReg, $userID, $newData, $individualPlayerData, $has, $igt]);
?>
FILE;

file_put_contents('../battleracer/g/sync.php', $file);

$file = <<<'FILE'
<?php
  require('db.php');
  $sql = "SELECT * FROM orbsMirrors";
  $res = mysqli_query($link, $sql);
  if(mysqli_num_rows($res)){
    $servers = [];
    for($i = 0; $i < mysqli_num_rows($res); ++$i){
      $row = mysqli_fetch_assoc($res);
      if($row['active']) $servers[] = $row;
    }
    $servers = json_encode($servers);
  }else{
    echo '[false]';
  }
?>
<DOCTYPE html>
<html>
  <head>
    <title>ARENA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      /* latin-ext */
      @font-face {
        font-family: 'Courier Prime';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/courierprime/v9/u-450q2lgwslOqpF_6gQ8kELaw9pWt_-.woff2) format('woff2');
        unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
      }
      /* latin */
      @font-face {
        font-family: 'Courier Prime';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/courierprime/v9/u-450q2lgwslOqpF_6gQ8kELawFpWg.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
      }
      body, html{
        margin: 0;
        background: #222;
        width: 100vw;
        height: 100vh;
        overflow: hidden;
        font-family: Courier Prime;
        font-size: 24px;
      }
      @media (orientation: landscape) {
        .pDiv{
          display: inline-block;
          width: 100%;
          height: calc(97% - 240px);
        }
        #returnButton{
          line-height: .9em;
          padding: 20px;
          min-width: 40px;
          min-height: unset;
          position: fixed;
          min-height: unset;
          right: 715px;
          top: -6px;
        }
        #mirrorsIframe{
          border: 0;
          margin: 0;
          width: 720px;
          height: 133vh;
          display: block;
          flat: left;
        }
        #practice{
          text-align: center;
          border: 0;
          margin: 0;
          vertical-align: top;
          background: linear-gradient(45deg, #000, #600);
          width: calc(133vw - 760px);
          display: block;
          color: #fff;
          padding: 20px;
          height: 133vh;
          float: left;
        }
        .practiceFrame{
          width: 100%;
          height: 100%;
          border: none;
          display: block;
        }
        hr{
          border: 1px solid #4f84;
          line-height: 0;
          margin: 0;
          padding: 0;
        }
        .logo{
          background-image: url(https://srmcgann.github.io/temp/burst.png);
          opacity: 100%;
          width: 150px;
          height: 150px;
          background-position: center center;
          background-size: 150px 150px;
          background-repeat: no-repeat;
          position: fixed;
          left: -10px;
          top: -10px;
        }
        .clear{
          clear: both;
        }
        #main{
          width: 133vw;
          height: 133vh;
          left: 50%;
          top: 50%;
          transform: translate(-50%, -50%) scale(.75, .75);
          position: fixed;
        }
      }

      @media (orientation: portrait) {
        .pDiv{
          display: inline-block;
            width: 100%;
            height: calc(97% - 240px);
        }
        #returnButton{
          line-height: .9em;
          padding: 20px;
          min-width: 40px;
          min-height: unset;
          position: fixed;
          right: -6px;
          top: -6px;
          animation-name: returnButton;
          animation-iteration-count: infinite;
        }
        #mirrorsIframe{
          border: 0;
          margin: 0;
          width: 133vw;
          height: 66vh;
          display: block;
          position: fixed;
          top: 66vh;
        }
        #practice{
          text-align: center;
          border: 0;
          margin: 0;
          vertical-align: top;
          padding: 20px;
          background: linear-gradient(45deg, #000, #600);
          width: calc(133vw - 40px);
          height: 66vh;
          display: block;
          color: #fff;
          height: 66vh;
        }
        .practiceFrame{
          width: 100%;
          height: 100%;
          border: none;
          display: block;
        }
        hr{
          border: 1px solid #4f84;
          line-height: 0;
          margin: 0;
          padding: 0;
        }
        .logo{
          background-image: url(https://srmcgann.github.io/temp/burst.png);
          opacity: 100%;
          width: 150px;
          height: 150px;
          background-position: center center;
          background-size: 150px 150px;
          background-repeat: no-repeat;
          position: fixed;
          left: -10px;
          top: -10px;
        }
        .clear{
          clear: both;
        }
        #main{
          transform: translate(-50%, -50%) scale(.75, .75);
          position: fixed;
          left: 50%;
          top: 50%;
          width: 133vw;
          height: 133vh;
        }
      }
      #practiceContainer{
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: space-evenly;
        flex-wrap: wrap;
        overflow: auto;
      }
      .title{
        width: calc(100% - 105px);
        float: right;
        text-align: left;
        padding-bottom: 10px;
        text-shadow: 2px 2px 2px #000;
      }
      .button:focus{
        outline: none;
      }
      .button{
        align-self: center;
        color: #0fa;
        background: #40cc;
        border: none;
        cursor: pointer;
        border-radius: 10px;
        font-size: 24px;
        padding: 5px;
        min-width: 100px;
        text-align: center;
        min-height: 360px;
        margin: 16px;
        min-width: 225px;
      }
      .gameThumbs{
        display: inline-block;
        width: 200px;
        height: 200px;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
      }
      #tictactoeThumb{
        background-image: url(tictactoeThumb.jpg);
      }
      #sideToSideThumb{
        background-image: url(sideToSideThumb.png);
        background-color: #000;
      }
      #puyopuyoThumb{
        background-image: url(puyopuyoThumb.jpg);
        background-color: #000;
      }
      #battleracerThumb{
        background-image: url(battleracerThumb.jpg);
        background-color: #000;
      }
      #tetrisThumb{
        background-image: url(tetrisThumb.jpg);
      }
      #orbsThumb{
        background-image: url(orbsThumb.jpg);
      }
      .captionContainer{
        display: block;
        margin: 5px;
        color: #fff;
        border-radius: 10px;
        width: 100%;
        font-size: 16px;
        max-width: calc(100% - 30px);
        padding: 10px;
        padding-top: 20px;
      }
      #backIcon{
        font-size: 3em;
        margin-top: 16px;
        display: inline-block;
      }
      #returnButton{
        animation-name: returnButton;
        animation-iteration-count: infinite;
        animation-duration: 2s;
        color: #fff;
        text-shadow: 2px 2px 2px #000;
        display: none;
      }
      .captionPractice{
        display: block;
        line-height: 2px;
      }
      .modal{
        width: 133vw;
        height: 133vh;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 2000;
        display: none;
        background: #123d;
        color: #fff;
        justify-content: space-evenly;
        flex-wrap: wrap;
        overflow: auto;
      }
      @keyframes returnButton {
        0%   {background-color: #184;}
        33%  {background-color: #148;}
        50%  {background-color: #841;}
        66%  {background-color: #418;}
        100%  {background-color: #184;}
      }
    </style>
  </head>
  <body>
    <div id="main">
      <div class="modal" id="buttonModal"></div>
      <div class="logo"></div>
      <div id="practice">
        <div class="title">
          <span style="font-size: 2em;">MULTIPLAYER</span>........<br>
          <center style="margin-left: -10%;font-size: 2em;">ARENA!</center><hr>
          practice here, then when you are ready,<br>
          create a game by clicking any of the mirror links
          <button id="returnButton" class="button" onclick="returnToGames()">
            <span style="float: left;">back to<br>games </span>
            <span id="backIcon">&#x293E;</span>
          </button>
          <br>
        </div>
        <div class="clear"></div>
        <div class="pdiv">
          <div id="practiceContainer"></div>
        </div>
      </div>
      <iframe id="mirrorsIframe" src="mirrors"></iframe>
    </div>
    <script>
      practiceContainer = document.querySelector('#practiceContainer')
      mirrorsIframe = document.querySelector('#mirrorsIframe')
      returnButton = document.querySelector('#returnButton')
      
      buttonModal = document.querySelector('#buttonModal')
      buttonModal.onclick = e => {
        e.stopPropagation()
        e.preventDefault()
        buttonModal.innerHTML = ''
        buttonModal.style.display = 'none'
      }
      
      shortWords=["aaron","aback","abase","abash","abate","abbey","abbot","abe","abeam","abed","abel","abet","abets","abhor","abide","able","ably","abode","abort","about","above","abuse","abut","abuts","abyss","ace","aces","ache","ached","aches","acid","acids","acme","acne","acorn","acre","acres","acrid","acryl","act","acted","actor","acts","acute","adage","adam","adams","adapt","add","added","adder","addle","adds","adept","adieu","adler","adman","admit","ado","adon","adopt","adore","adorn","adult","aegis","aesop","afar","affix","afire","afoot","afore","afoul","afro","aft","after","again","agana","agape","agate","age","aged","agent","ages","agile","aging","aglow","agnes","ago","agog","agony","agree","aha","ahead","ahem","ahoy","aid","aida","aide","aided","aider","aides","aids","ail","ailed","ails","aim","aimed","aims","air","aired","airs","airy","aisle","ajar","ajax","akin","alamo","alan","alarm","alas","album","alder","ale","alec","alert","ales","alex","algae","alias","alibi","alice","alien","align","alike","alit","alive","all","allah","allan","allay","alley","allot","allow","alloy","ally","alm","alms","aloft","aloha","alone","along","aloof","aloud","alp","alpha","alps","also","altar","alter","alto","altos","alum","alvin","amain","amass","amaze","amber","ambit","amble","ameba","amen","amend","amid","amine","amino","amiss","amity","amman","amok","among","amos","amour","amp","ample","amply","amps","amuck","amuse","amy","anal","and","andes","andre","andy","anew","angel","anger","angle","anglo","angry","angst","angus","anise","anita","ankle","ann","anna","anne","annex","annie","annoy","annul","annum","anode","anon","ant","ante","anti","antic","anton","ants","anus","anvil","any","aorta","apace","apart","ape","aped","apes","apex","aphid","apia","aping","apish","apple","apply","april","apron","apse","apt","aptly","aqua","arab","arabs","arbor","arc","arced","arch","arcs","arden","ardor","are","area","areas","arena","argh","argon","argos","argot","argue","argus","aria","arias","arid","aries","aril","arise","ark","arks","arm","armed","armor","arms","army","aroma","arose","array","arrow","arse","arson","art","arts","arty","aruba","arvin","aryan","ascii","ascot","ash","ashen","ashes","ashy","asia","asian","aside","ask","asked","asker","askew","asks","asp","aspen","aspic","asps","ass","assam","assay","asses","asset","aster","astir","ate","atilt","atlas","atoll","atom","atoms","atone","atop","attic","audio","audit","auger","aught","augur","auk","auks","auld","aunt","aunts","aura","aural","auras","auto","autos","avail","avant","aver","avers","avert","avery","avid","avoid","avon","avow","avows","await","awake","award","aware","awash","away","awe","awed","awes","awful","awing","awl","awls","awn","awoke","awol","awry","axed","axes","axial","axing","axiom","axis","axle","axles","aye","ayes","aztec","azure","baba","babe","babes","baby","bach","back","backs","bacon","bad","bade","badge","badly","bag","bagel","baggy","bags","bah","bail","bails","bait","baits","baize","bake","baked","baker","bakes","bald","bale","baler","bales","bali","balk","balks","balky","ball","balls","balm","balms","balmy","balsa","bambi","ban","banal","banco","band","bands","bandy","bane","banff","bang","bangs","banjo","bank","banks","banns","bans","bantu","bar","barb","barbs","bard","bards","bare","bared","bares","barge","bark","barks","barn","barns","baron","barry","bars","bart","basal","base","based","basel","baser","bases","bash","basic","basil","basin","basis","bask","basks","basle","basra","bass","bast","baste","bat","bata","batch","bate","bated","bates","bath","bathe","baths","baton","bats","batty","baud","baulk","bawd","bawds","bawdy","bawl","bawls","bay","bayou","bays","bbc","beach","bead","beads","beady","beak","beaks","beam","beams","bean","beans","bear","beard","bears","beast","beat","beats","beau","beaux","bebop","beck","bed","beds","bee","beech","beef","beefs","beefy","been","beep","beeps","beer","beers","bees","beet","beets","befit","befog","beg","began","beget","begin","begot","begs","begun","beige","being","belay","belch","belie","bell","belle","bello","bells","belly","below","belt","belts","ben","bench","bend","bends","benin","bent","beret","berg","bergs","bern","berry","bert","berth","beryl","beset","bess","best","bests","bet","beta","betel","beth","bets","betsy","betty","bevel","bevy","bias","bib","bible","bibs","bid","biddy","bide","bided","bides","bidet","bids","bier","biers","big","bight","bigot","bike","biked","bikes","bile","bilge","bill","bills","billy","bin","bind","binds","binge","bingo","bins","bios","biped","birch","bird","birds","birth","bison","bit","bite","biter","bites","bits","bitty","blab","blabs","black","blade","blake","blame","bland","blank","blare","blase","blast","blaze","bleak","blear","bleat","bled","bleed","bleep","blend","bless","blest","blew","blimp","blind","blink","blip","blips","bliss","blitz","bloat","blob","blobs","bloc","block","bloke","blond","blood","bloom","blot","blots","blow","blown","blows","blue","blues","bluff","blunt","blur","blurb","blurs","blurt","blush","boa","boar","board","boars","boas","boast","boat","boats","bob","bobby","bobs","bode","boded","bodes","bods","body","boer","boers","bog","bogey","boggy","bogie","bogs","bogus","bogy","boil","boils","bold","bolt","bolts","bomb","bombs","bond","bonds","bone","boned","boner","bones","bong","bongo","bonn","bonny","bonus","bony","boo","boob","boobs","booby","booed","book","books","boom","booms","boon","boons","boor","boors","boos","boost","boot","booth","boots","booty","booze","boozy","bop","borax","bore","bored","borer","bores","boris","born","borne","boron","bosh","bosom","boss","bossy","bosun","botch","both","bough","bound","bout","bouts","bow","bowed","bowel","bower","bowie","bowl","bowls","bows","box","boxed","boxer","boxes","boy","boyd","boys","bra","brace","brad","brads","brag","brags","braid","brain","brake","bran","brand","bras","brash","brass","brat","brats","brave","bravo","brawl","brawn","bray","brays","braze","bread","break","bream","bred","breed","brew","brews","brian","briar","bribe","brick","bride","brie","brief","brier","brig","brim","brims","brine","bring","brink","briny","brio","brisk","broad","broil","broke","bronx","brood","brook","broom","broth","brow","brown","brows","bruce","brunt","brush","brute","bryan","bsc","btu","buck","bucks","bud","buddy","budge","buds","buff","buffs","bug","buggy","bugle","bugs","build","built","bulb","bulbs","bulge","bulk","bulks","bulky","bull","bulls","bully","bum","bump","bumps","bumpy","bums","bun","bunch","bung","bungs","bunk","bunks","bunny","buns","buoy","buoys","burke","burly","burma","burn","burns","burnt","burp","burps","burr","burrs","burst","bury","bus","buses","bush","bushy","bust","busts","busy","but","butch","butt","butte","butts","buxom","buy","buyer","buys","buzz","bye","bylaw","byres","byron","byte","bytes","byway","cab","cabal","cabby","cabin","cable","cabs","cache","cacti","cad","caddy","cadet","cadge","cadre","cads","cafe","cafes","cage","caged","cages","cagey","cain","cairn","cairo","cake","caked","cakes","calf","call","calls","calm","calms","calve","cam","camas","came","camel","cameo","camp","camps","cams","can","can't","canal","candy","cane","caned","canes","cank","canna","canny","canoe","canon","cans","cant","canto","cants","cap","cape","caper","capes","capon","caps","car","carat","card","cards","care","cared","cares","carew","carey","cargo","carol","carp","carps","carry","cars","cart","carts","carve","case","cased","cases","cash","cask","casks","cast","caste","casts","cat","catch","cater","cathy","cats","catty","caulk","cause","cave","caved","caves","cavil","caw","cawed","caws","cbi","cease","cecil","cedar","cede","ceded","cedes","celia","cell","cello","cells","celt","celts","cent","cents","chad","chafe","chaff","chain","chair","chalk","champ","chant","chaos","chap","chaps","char","chard","charm","chars","chart","chary","chase","chasm","chat","chats","cheap","cheat","check","cheek","cheep","cheer","chef","chefs","chess","chest","chew","chews","chewy","chi","chic","chick","chide","chief","child","chile","chili","chill","chime","chimp","chin","china","chine","chink","chins","chip","chips","chirp","chit","chits","chive","chivy","chock","choir","choke","chomp","chop","chops","chord","chore","chose","chow","chows","chris","chubb","chuck","chuff","chug","chugs","chum","chump","chums","chunk","churl","churn","chute","cid","cider","cigar","cinch","cindy","circa","cite","cited","cites","city","civi","civic","civil","clack","clad","claim","clam","clamp","clams","clan","clang","clank","clans","clap","claps","clark","clash","clasp","class","claus","claw","claws","clay","clays","clean","clear","cleat","clef","clefs","cleft","clerk","click","cliff","climb","clime","cling","clink","clint","clip","clips","clive","cloak","clock","clod","clods","clog","clogs","clone","clonk","close","clot","cloth","clots","cloud","clout","clove","clown","cloy","cloys","club","clubs","cluck","clue","clues","clump","clung","coach","coal","coals","coast","coat","coats","coax","cob","cobol","cobra","cobs","coca","cock","cocks","cocky","cocoa","cod","coda","code","coded","codes","cog","cogs","cohen","coil","coils","coin","coins","coke","cokes","cola","cold","colds","cole","colic","colin","colne","colon","color","colt","colts","coma","comas","comb","combs","come","comer","comes","comet","comfy","comic","comma","con","conch","cone","coned","cones","coney","conga","congo","conic","conk","conks","cons","cony","coo","cooed","cook","cooks","cool","cools","coop","coops","coot","coots","cop","cope","coped","copes","cops","copse","copt","copts","copy","coral","cord","cords","core","cored","corer","cores","corey","corfu","corgi","cork","corks","corky","corn","corns","corny","corps","cos","cosec","cosh","cost","costs","cot","cots","couch","cough","could","count","coup","coupe","coups","court","cove","coven","cover","coves","covet","cow","cowed","cower","cowl","cowls","cows","cox","coy","coyly","coypu","cozy","crab","crabs","crack","craft","crag","crags","craig","cram","cramp","crams","crane","crank","crash","crass","crate","crave","craw","crawl","craws","craze","crazy","creak","cream","credo","creed","creek","creep","crepe","crept","cress","crest","crete","crew","crews","cri","crib","cribs","crick","cried","crier","cries","crime","crimp","crisp","croak","crock","crone","crony","crook","croon","crop","crops","cross","crow","crowd","crown","crows","crude","cruel","cruet","crumb","crush","crust","crux","cry","crypt","cub","cuba","cuban","cube","cubed","cubes","cubic","cubit","cubs","cud","cue","cued","cues","cuff","cuffs","cull","culls","cult","cults","cumin","cup","cupid","cups","cur","curae","curb","curbs","curd","curds","cure","cured","cures","curia","curie","curio","curl","curls","curly","curry","curs","curse","curst","curt","curve","cushy","cusp","cusps","cuss","cut","cute","cuter","cuts","cwt","cyan","cycle","cynic","cyril","cyst","cysts","czar","czars","czech","dab","dabs","dacca","dace","dacha","dad","daddy","dads","daffy","daft","daily","dairy","dais","daisy","dakar","dal","dale","dales","dally","dam","dame","dames","damn","damns","damp","damps","dams","dan","dance","dandy","dane","dank","danny","dante","dare","dared","dares","dark","darn","darns","dart","darts","dash","data","date","dated","dater","dates","datum","daub","daubs","daunt","dave","david","davis","davit","davy","dawn","dawns","day","days","daze","dazed","dazes","dazy","ddt","dead","deaf","deal","deals","dealt","dean","deans","dear","dears","death","deb","debar","debit","debra","debt","debts","debug","debut","decay","deck","decks","deco","decor","decoy","decry","deed","deeds","deem","deems","deep","deer","deere","defer","defog","deft","defy","degas","deify","deign","deism","deist","deity","delay","delft","delhi","dell","delta","delve","demi","demo","demon","demur","den","denim","denis","dens","dense","dent","dents","deny","depot","dept","depth","derek","desk","desks","deter","deuce","devil","dew","dewed","dewy","dfc","dhabi","dial","dials","diana","diane","diary","dice","diced","dices","dicey","dick","dicta","did","die","died","dies","diet","diets","dig","digit","digs","dijon","dike","dikes","dill","dim","dime","dimes","dimly","dims","din","dinar","dine","dined","diner","dines","ding","dingo","dings","dingy","dinky","dint","diode","dip","dips","dire","dirge","dirt","dirty","disc","disco","discs","dish","disk","disks","ditch","ditto","ditty","diva","divan","divas","dive","dived","diver","dives","dixie","dixon","dizzy","djinn","dna","doc","dock","docks","dodge","dodo","dodos","doe","doer","doers","does","doff","doffs","dog","doggy","dogma","dogs","doily","doing","dole","doled","doles","doll","dolls","dolly","dolt","dolts","dome","domed","domes","don","don't","done","donee","dong","doni","donna","donor","dons","doom","dooms","door","doors","dope","doped","doper","dopes","dopey","dora","doric","doris","dorm","dorsa","dory","dose","dosed","doses","doss","dot","dote","doted","dotes","dots","dotty","doubt","doug","dough","dour","douse","dove","dover","doves","dow","dowdy","dowel","dower","down","downs","downy","dowry","dowse","doyle","doze","dozed","dozen","dozes","dozy","drab","draft","drag","drags","drain","drake","dram","drama","drank","drape","drat","draw","drawl","drawn","draws","dray","dread","dream","dregs","dress","drew","dried","drier","dries","drift","drill","drily","drink","drip","drips","drive","droll","drone","drool","droop","drop","drops","dross","drove","drown","drub","drug","drugs","druid","drum","drums","drunk","dry","dryer","dryly","dsc","dual","dub","dubs","ducal","ducat","duchy","duck","ducks","duct","ducts","dud","dude","duds","due","duel","duels","dues","duet","duets","duff","dug","duke","dukes","dull","dully","duly","dumb","dummy","dump","dumps","dumpy","dun","dunce","dune","dunes","dung","dunk","dunks","duns","duo","dupe","duped","duper","dupes","duple","dusk","dusky","dust","dusts","dusty","dutch","duty","dwarf","dwell","dwelt","dye","dyed","dyer","dyers","dyes","dying","dyke","dykes","dylan","each","eager","eagle","ear","eared","earl","earls","early","earn","earns","ears","earth","ease","eased","easel","eases","east","easy","eat","eaten","eater","eaton","eats","eave","eaves","ebb","ebba","ebbed","ebbs","ebony","echo","eclat","ecru","edam","eddy","edema","eden","edgar","edge","edged","edges","edgy","edict","edify","edit","edith","edits","edna","educe","edwin","eel","eels","eerie","egg","egged","eggs","ego","egos","egret","egypt","eider","eight","eire","eject","eke","eked","ekes","eking","elan","eland","elate","elba","elbe","elbow","elder","elect","elegy","elf","elfin","eli","elias","elise","elite","elk","elks","ell","ella","ellen","elm","elms","elope","else","elsie","elude","elves","elvis","emacs","embed","ember","emend","emery","emil","emily","emir","emit","emits","emma","empty","emu","emus","enact","end","ended","endow","ends","endue","ene","enema","enemy","enid","enjoy","ennui","enoch","ens","ensue","enter","entry","envoy","envy","eon","eons","epee","epees","epic","epics","epoch","epoxy","epsom","equal","equip","era","eras","erase","erect","erg","ergo","ergs","eric","erie","erin","ernst","erode","eros","err","erred","errol","error","errs","erupt","esau","esc","ese","esker","espy","essay","esse","ester","estop","eta","etc","etch","ethel","ether","ethic","ethos","etna","etui","evade","evan","eve","even","evens","event","ever","every","evict","evil","evils","evoke","ewe","ewer","ewers","ewes","exact","exalt","exam","exams","excel","exe","exec","exert","exile","exist","exit","exits","expel","extol","extra","exude","exult","exxon","eye","eyed","eyes","eyre","ezra","faber","fable","face","faced","faces","facet","fact","facts","fad","faddy","fade","faded","fades","fads","fag","fagot","fags","fail","fails","fain","faint","fair","fairs","fairy","faith","fake","faked","faker","fakes","fakir","fall","falls","false","fame","famed","fan","fancy","fang","fangs","fanny","fans","far","farad","farce","fare","fared","fares","farm","farms","faro","faros","fast","fasts","fat","fatal","fate","fated","fates","fats","fatty","fault","fauna","faust","favor","fawn","fawns","fax","faxed","faxes","fay","faze","fear","fears","feast","feat","feats","fecal","feces","fed","fee","feed","feeds","feel","feels","fees","feet","feign","feint","fell","fells","felo","felon","felt","femur","fen","fence","fend","fends","fens","feral","fermi","fern","ferns","ferry","fetal","fetch","fete","feted","fetes","fetid","fetus","feud","feuds","fever","few","fewer","fey","fez","fiat","fiats","fib","fiber","fibs","fief","field","fiend","fiery","fife","fifes","fifth","fifty","fig","fight","figs","fiji","filch","file","filed","filer","files","filet","fill","fills","filly","film","films","filmy","filth","fin","final","finch","find","finds","fine","fined","finer","fines","finn","fins","fir","fire","fired","fires","firm","firms","firs","first","firth","fish","fishy","fist","fists","fit","fitch","fitly","fits","five","fives","fix","fixed","fixer","fixes","fizz","fizzy","fjord","flag","flags","flail","flair","flak","flake","flaky","flame","flan","flank","flap","flaps","flare","flash","flask","flat","flats","flaw","flaws","flax","flay","flays","flea","fleas","fleck","fled","flee","flees","fleet","flesh","flew","flex","flick","flier","flies","fling","flint","flip","flips","flirt","flit","flits","float","flock","floe","floes","flog","flogs","flood","floor","flop","flops","flora","floss","flour","flout","flow","flown","flows","flp","flu","flue","flues","fluff","fluid","fluke","flung","flunk","fluor","flush","flute","flux","fly","flyer","foal","foals","foam","foams","foamy","fob","fobs","focal","foci","focus","foe","foes","fog","fogey","foggy","fogs","fogy","foil","foils","foist","fold","folds","folio","folk","folks","folly","fond","font","fonts","food","foods","fool","fools","foot","fop","for","foray","force","ford","fords","fore","forge","forgo","fork","forks","form","forms","fort","forte","forth","forts","forty","forum","foul","fouls","found","fount","four","fours","fowl","fowls","fox","foxed","foxes","foxy","foyer","frail","frame","franc","frank","fraud","fray","frays","freak","fred","freda","free","freed","frees","freon","fresh","fret","frets","freud","friar","fried","fries","frill","frisk","frizz","fro","frock","frog","frogs","from","frond","front","frost","froth","frown","froze","frs","fruit","frump","fry","fudge","fuel","fuels","fugal","fugue","fuji","full","fully","fume","fumed","fumes","fun","fund","funds","fungi","funk","funks","funky","funny","fur","furl","furor","furry","furs","fury","furze","fuse","fused","fuses","fuss","fussy","fusty","futon","fuzz","fuzzy","gab","gable","gabon","gad","gael","gaffe","gag","gage","gages","gags","gail","gaily","gain","gains","gait","gaits","gal","gala","galas","gale","gales","gall","galls","gals","game","games","gamin","gamma","gamp","gamut","gang","gangs","gap","gape","gaped","gapes","gaps","garb","gary","gas","gases","gash","gasp","gasps","gassy","gate","gated","gates","gatt","gaudy","gauge","gaul","gaunt","gauss","gauze","gauzy","gave","gavel","gavin","gawk","gawks","gawky","gay","gays","gaze","gazed","gazer","gazes","gazon","gear","gears","gee","geese","gel","geld","gem","gems","gene","genes","genet","genie","genii","genoa","genre","genus","geoff","germ","germs","get","gets","getup","ghana","ghent","ghost","ghoul","giant","gibe","gibed","gibes","giddy","gift","gifts","gig","gigs","gild","gilds","gill","gills","gilt","gin","gins","gipsy","gird","girds","girl","girls","giro","giros","girth","gist","give","given","giver","gives","gizmo","glace","glad","glade","gland","glare","glass","glaze","gleam","glean","glee","glen","glens","glib","glide","glint","gloat","globe","gloms","gloom","glory","gloss","glove","glow","glows","glue","glued","glues","gluey","glum","glut","gluts","gmt","gnarl","gnash","gnat","gnats","gnaw","gnaws","gnome","gnu","gnus","goad","goads","goal","goals","goat","goats","gob","gobi","god","godly","gods","goes","gofer","going","gold","golf","golly","gonad","gone","goner","gong","gongs","goo","good","goods","goody","goof","goofs","goofy","goon","goose","gore","gored","gores","gorge","gorse","gory","gosh","got","goth","gouda","gouge","gourd","gout","gouty","gown","gowns","goya","grab","grabs","grace","grad","grade","graft","grail","grain","gram","grams","grand","grant","grape","graph","grasp","grass","grate","grave","gravy","gray","grays","graze","great","grebe","greed","greek","green","greet","grew","grid","grids","grief","grieg","grill","grim","grime","grimy","grin","grind","grins","grip","gripe","grips","grist","grit","grits","groan","groat","grog","groin","groom","grope","gross","group","grout","grove","grow","growl","grown","grows","grub","grubs","gruel","gruff","grump","grunt","guam","guano","guard","guava","guess","guest","guide","guild","guile","guilt","guise","gulf","gulfs","gull","gulls","gully","gulp","gulps","gum","gumbo","gummy","gums","gun","gunk","gunny","guns","guppy","guru","gurus","gus","gush","gushy","gust","gusto","gusts","gusty","gut","guts","gutsy","guy","guys","gym","gyms","gypsy","gyro","gyros","habet","habit","hack","hacks","had","hades","hag","hags","hague","haifa","haiku","hail","hails","hair","hairs","hairy","haiti","hake","hale","haley","half","hall","halls","halo","halos","halt","halts","halve","ham","hammy","hams","hand","hands","handy","hang","hangs","hank","hanks","hanky","hanna","hanoi","hanse","haply","happy","hard","hardy","hare","harem","hares","hark","harks","harm","harms","harp","harps","harpy","harry","harsh","hart","harts","has","hash","hasp","hasps","haste","hasty","hat","hatch","hate","hated","hater","hates","hats","haugh","haul","hauls","haunt","hausa","have","haven","haver","havoc","hawk","hawks","hawse","hay","haydn","hayed","hays","haze","hazel","hazes","hazy","he'd","he'll","he's","head","heads","heady","heal","heals","heap","heaps","hear","heard","hears","heart","heat","heath","heats","heave","heavy","heck","hedge","heed","heeds","heel","heels","heft","hefty","heinz","heir","heirs","heist","held","helen","helix","hell","hello","helm","helms","helot","help","helps","hem","hemp","hems","hen","hence","henry","hens","her","herb","herbs","herd","herds","here","hero","heron","hers","hertz","hess","hew","hewed","hewer","hewn","hews","hex","hey","hick","hid","hide","hides","hifi","high","highs","hike","hiked","hiker","hikes","hill","hills","hilly","hilt","hilts","him","hind","hindi","hinds","hindu","hinge","hint","hints","hip","hippy","hips","hire","hired","hirer","hires","his","hiss","hit","hitch","hits","hive","hived","hives","hmos","hoard","hoary","hoax","hob","hobby","hobo","hobs","hoc","hock","hocks","hod","hods","hoe","hoed","hoes","hog","hogs","hoist","hold","holds","hole","holed","holes","holly","holm","holst","holy","home","homed","homer","homes","homo","honda","honey","honk","honks","honor","hooch","hood","hoods","hooey","hoof","hoofs","hook","hooks","hooky","hoop","hoops","hoot","hoots","hop","hope","hoped","hopes","hops","horde","horn","horns","horny","horse","hose","hosea","hosed","hoses","host","hosts","hot","hotch","hotel","hotly","hound","hour","hours","house","hove","hovel","hover","how","howdy","howl","howls","hoy","hub","hubby","hubs","hue","hued","hues","huff","huffs","huffy","hug","huge","hugh","hugs","huh","hula","hulk","hulks","hull","hulls","hum","human","humid","humor","hump","humps","humpy","hums","humus","hun","hunch","hung","hunk","hunt","hunts","hurl","hurls","huron","hurry","hurt","hurts","hush","husk","husks","husky","hussy","hut","hutch","huts","hydra","hydro","hyena","hymen","hymn","hymns","hype","hyped","hyper","hypes","hypo","hyrax","i'd","i'll","i'm","i've","iamb","ian","iata","ibex","ibi","ibid","ibis","ibsen","ice","iced","ices","icily","icing","icon","icons","icy","ida","idaho","idea","ideal","ideas","idem","ides","idiom","idiot","idle","idled","idler","idles","idly","idol","idols","idyl","idyll","igloo","iii","ikon","iliad","ilk","ill","ills","ilo","image","imago","imam","imams","imbed","imbue","imf","imp","impel","imply","imps","ina","inane","inapt","inca","inch","incur","index","india","indus","inept","inert","infer","info","infra","ingot","ink","inked","inks","inky","inlay","inlet","inn","inner","inns","input","inset","inter","into","inure","ion","ionic","ions","iota","iowa","ira","iran","iraq","iraqi","irate","ire","irene","iris","irish","irk","irked","irks","iron","irons","irony","isaac","isbn","isis","islam","isle","isles","islet","isn't","issue","it'd","it'll","it's","italy","itch","itchy","item","items","its","ivory","ivy","jab","jabs","jack","jacks","jacob","jade","jaded","jades","jaffa","jag","jags","jail","jails","jake","jam","jamb","james","jamey","jams","jan","jane","janet","janus","japan","jape","jar","jars","jason","jaunt","java","jaw","jawed","jaws","jay","jays","jazz","jazzy","jean","jeans","jeep","jeeps","jeer","jeers","jeff","jelly","jenny","jerk","jerks","jerky","jerry","jesse","jest","jests","jesus","jet","jets","jetty","jew","jewel","jewry","jews","jib","jibe","jibed","jibes","jibs","jiffy","jig","jigs","jill","jilt","jilts","jim","jimmy","jinn","jinx","jive","jived","jives","joan","job","jobs","jock","joe","joey","jog","jogs","john","join","joins","joint","joist","joke","joked","joker","jokes","jolly","jolt","jolts","jones","jot","jots","joule","jours","joust","jove","jowl","jowls","jowly","joy","joyce","joys","judas","judea","judge","judo","judy","jug","jugs","juice","juicy","juju","julia","julie","july","julys","jumbo","jump","jumps","jumpy","june","junes","jung","junk","junks","junta","jura","juror","jury","just","jut","jute","juts","kabul","kafka","kale","kaman","kapok","kaput","karat","karen","karma","kate","kathy","katie","kay","kayak","kbyte","kebab","keel","keels","keen","keep","keeps","keg","kegs","keith","kelly","kelp","ken","kenya","kepi","kept","kerf","ketch","kevin","key","keyed","keys","khaki","khan","kick","kicks","kid","kids","kiev","kill","kills","kiln","kilns","kilo","kilos","kilt","kilts","kim","kin","kind","kinds","king","kings","kink","kinks","kinky","kiosk","kips","kirk","kiss","kit","kite","kited","kites","kith","kits","kitty","kiwi","kiwis","klieg","knack","knave","knead","knee","kneed","kneel","knees","knell","knelt","knew","knife","knit","knits","knob","knobs","knock","knoll","knot","knots","know","known","knows","knox","knurl","koala","kobe","kodak","koran","korea","kraal","kraft","kraut","krone","kudos","kyoto","lab","label","labor","labs","lace","laced","lacer","laces","lack","lacks","lad","lade","laden","ladle","lads","lady","lag","lager","lagos","lags","laid","lain","lair","lairs","laity","lake","lakes","lamb","lambs","lame","lamp","lamps","lance","land","lands","lane","lanes","lank","lanky","laos","lap","lapel","laps","lapse","larch","lard","lards","large","lark","larks","larry","larva","laser","lash","lass","lasso","last","lasts","latch","late","later","latex","lath","lathe","laths","latin","laud","lauds","laugh","laura","lava","law","lawn","lawns","laws","lax","laxly","lay","laye","layer","lays","layup","laze","lazed","lazes","lazy","lea","lead","leads","leaf","leafs","leafy","leak","leaks","leaky","lean","leans","leant","leap","leaps","leapt","learn","leas","lease","leash","least","leave","led","ledge","lee","leech","leeds","leek","leeks","leer","leers","leery","lees","left","lefty","leg","legal","leges","leggy","legs","leigh","lemon","lemur","len","lend","lends","lenin","lens","lent","lento","leo","leon","leper","less","lest","let","lets","letup","levee","level","lever","levi","levy","lewd","ley","lhasa","liar","liars","libel","libra","libya","lice","lick","licks","lid","lids","lie","lied","liege","lien","liens","lies","lieu","life","lifer","lift","lifts","light","like","liked","liken","likes","lilac","lilly","lilt","lilts","lily","lima","limb","limbo","limbs","lime","limed","limes","limey","limit","limo","limp","limps","limy","linda","line","lined","linen","liner","lines","lingo","link","links","lint","lion","lions","lip","lipid","lips","lira","lisa","lisp","lisps","list","lists","liszt","lit","liter","lithe","live","lived","liven","liver","lives","livid","liz","llama","load","loads","loaf","loafs","loam","loamy","loan","loans","loath","lob","lobby","lobe","lobes","lobs","local","loch","lochs","lock","locks","locum","locus","lode","lodge","loft","lofts","lofty","log","logic","logo","logos","logs","loin","loins","loire","loll","lolls","lone","loner","long","longs","look","looks","loom","looms","loon","loony","loop","loops","loopy","loose","loot","loots","lop","lope","loped","lopes","lops","loral","loran","lord","lords","lore","lorry","lose","loser","loses","loss","lost","lot","loth","lots","lotus","loud","louis","louse","lousy","lout","louts","love","loved","lover","loves","low","lower","lowly","loyal","lrun","ltd","lucas","lucid","luck","lucks","lucky","lucre","ludic","lug","lugs","luis","luke","lull","lulls","lulu","lumen","lump","lumps","lumpy","lunar","lunch","lung","lunge","lungs","lupin","lurch","lure","lured","lures","lurid","lurk","lurks","lush","lust","lusts","lusty","lute","lutes","luxe","luzon","lye","lying","lymph","lynch","lynn","lynx","lyon","lyons","lyre","lyric","mac","macao","macaw","mace","maced","maces","mach","macho","macro","mad","madam","made","madly","mae","mafia","magi","magic","magna","maid","maids","mail","mails","maim","maims","main","maine","mains","maize","major","make","maker","makes","malay","male","males","mali","mall","malls","malt","malta","malts","malty","malum","mama","mamas","mambo","mamma","mammy","man","mane","manes","mange","mango","mangy","mania","manic","manly","mann","manna","manor","mans","manse","manx","many","mao","maori","map","maple","maps","mar","march","marco","mare","mares","maria","marie","mario","mark","marks","marry","mars","marsh","mart","marts","marx","mary","maser","mash","mask","masks","mason","mass","massy","mast","masts","mat","match","mate","mated","mater","mates","maths","mats","matte","matzo","maui","maul","mauls","mauve","maw","maxi","maxim","may","maybe","mayor","mays","maze","mazes","mdv","mead","meal","meals","mealy","mean","means","meant","meat","meats","meaty","mecca","medal","media","medic","meek","meet","meets","mega","mel","melba","melon","melt","melts","memo","memos","men","mend","mends","mente","menu","menus","meow","meows","mercy","mere","merge","merit","merry","mers","mesh","mess","messy","met","metal","meted","meter","meth","meths","metro","mew","mewed","mews","mezzo","mho","miami","mica","micah","mice","micro","mid","midas","midge","midst","mien","miens","miff","miffs","mig","might","mike","mil","milan","mild","mile","miles","milk","milks","milky","mill","milli","mills","mils","milt","mime","mimed","mimer","mimes","mimi","mimic","mince","mind","minds","mine","mined","miner","mines","mini","minim","mink","minks","minor","mint","mints","minty","minus","minx","mirth","miser","miss","missy","mist","mists","misty","mite","miter","mites","mitt","mix","mixed","mixer","mixes","mixup","moan","moans","moat","moats","mob","mobil","mobs","mocha","mock","mocks","mod","modal","mode","model","modem","modes","modi","modus","mogul","moist","molar","mold","molds","moldy","mole","moles","moll","molls","molly","molt","molts","momma","mommy","monet","money","monk","monks","mono","month","moo","mooch","mood","moods","moody","mooed","moon","moons","moor","moors","moos","moose","moot","moots","mop","mope","moped","mopes","mops","moral","moray","more","mores","morn","moron","morse","mort","moses","moss","mossy","most","mote","motel","motes","motet","moth","moths","motif","motor","motto","mound","mount","mourn","mouse","mousy","mouth","move","moved","mover","moves","movie","mow","mowed","mower","mown","mows","mrs","much","muck","mucks","mucky","mucus","mud","muddy","muff","muffs","mufti","mug","muggy","mugs","mulch","mule","mules","mull","mulls","multi","mum","mummy","mumps","mums","munch","mural","murky","muse","mused","muses","mush","mushy","music","musk","musky","must","musts","musty","mute","muted","mutes","muzak","myna","mynah","myrrh","myth","myths","nab","nabob","nabs","nadir","naf","nag","nags","nail","nails","naive","naked","name","named","names","nancy","nanny","nap","napes","nappy","naps","nasal","nasty","natal","nato","natty","naval","nave","navel","naves","navy","nay","nazi","nazis","nco","neap","near","nears","neat","neck","necks","nee","need","needs","needy","negro","nehru","neigh","neil","neo","neon","nepal","nero","nerve","nervy","nest","nests","net","nets","never","nevil","new","newer","newly","news","newsy","newt","newts","next","nib","nibs","nice","nicer","niche","nick","nicks","niece","nifty","nigel","niger","nigh","night","nil","nile","nine","nines","ninny","ninth","nip","nippy","nips","nit","niter","nitro","nits","nixon","nne","nnw","noah","nobel","noble","nobly","nod","nodal","node","nodes","nods","noel","noes","noise","noisy","nomad","non","none","nook","nooks","noon","noose","nor","norm","norms","norse","north","nose","nosed","noses","nosey","nosy","not","notae","notch","note","noted","notes","noun","nouns","nova","novae","novel","now","nude","nudes","nudge","nul","null","numb","numbs","nun","nuns","nurse","nut","nuts","nutty","nylon","nymph","oaf","oafs","oak","oaks","oakum","oar","oars","oases","oasis","oat","oath","oaths","oats","obese","obey","obeys","oboe","oboes","occur","ocean","ochre","octal","octet","odd","odder","oddly","odds","ode","odes","odium","odor","oed","oems","off","offal","offer","oft","often","ogle","ogled","ogles","ogre","ogres","ohio","ohm","ohmic","ohms","oil","oiled","oiler","oils","oily","okapi","okay","okra","old","olden","older","oldie","olds","olive","omaha","oman","omega","omen","omens","omit","omits","once","one","ones","onion","only","onset","onto","onus","onyx","oops","ooze","oozed","oozes","oozy","opal","opec","open","opens","opera","opine","opium","opt","opted","optic","opts","opus","oral","orals","orate","orb","orbed","orbit","orbs","order","ore","ores","organ","orgy","orion","osaka","oscar","osier","oslo","other","otter","ouch","ought","ounce","our","ours","oust","ousts","out","outdo","outer","outre","outs","ouzel","ova","oval","ovals","ovary","ovate","oven","ovens","over","overs","overt","ovine","ovoid","ovum","owe","owed","owes","owing","owl","owlet","owls","owly","own","owned","owner","owns","oxen","oxide","oxlip","ozone","pace","paced","pacer","paces","pack","packs","pact","pacts","pad","paddy","padre","pads","pagan","page","paged","pages","paid","pail","pails","pain","pains","paint","pair","pairs","pal","pale","paled","paler","pales","pall","palls","palm","palms","palo","pals","palsy","pam","pan","panda","pane","panel","panes","pang","pangs","panic","pans","pansy","pant","pants","panty","pap","papa","papal","paper","papua","par","parch","pare","pared","paris","park","parka","parks","parry","parse","part","parts","party","parva","pass","past","pasta","paste","pasty","pat","patch","pate","paten","pater","path","paths","patio","patna","pats","patsy","patty","paul","paula","pause","pave","paved","paves","paw","pawed","pawn","pawns","paws","pax","pay","payee","payer","pays","pea","peace","peach","peak","peaks","peaky","peal","peals","pear","pearl","pears","peas","peat","peaty","pecan","peck","pecks","pedal","pee","peed","peek","peeks","peel","peels","peep","peeps","peer","peers","pees","peeve","peg","pegs","pelt","pelts","pen","penal","pence","pend","pends","penis","penn","penny","pens","pent","peony","pep","peppy","peps","pepsi","per","perch","peril","perk","perks","perky","perm","perms","pert","perth","peru","pesky","peso","pest","pests","pet","petal","pete","peter","petro","pets","petty","pew","pewee","pews","phase","phd","phial","phil","phone","phony","photo","phyla","piano","pica","pick","picks","pie","piece","pied","pier","piers","pies","piety","pig","piggy","pigmy","pigs","pike","piker","pikes","pilaf","pile","piled","piles","pill","pills","pilot","pimp","pimps","pin","pinch","pine","pined","pines","ping","pings","pink","pinks","pins","pint","pints","pinup","pious","pip","pipe","piped","piper","pipes","pips","pique","pisa","piss","piste","pit","pitch","pith","pithy","piton","pits","pitt","pitta","pity","pivot","pixel","pixie","pixy","pizza","place","plaid","plain","plait","plan","plane","plank","plans","plant","plate","plato","play","plays","plaza","plea","plead","pleas","pleat","plebs","plied","plies","pliny","plod","plods","plop","plops","plot","plots","ploy","ploys","pluck","plug","plugs","plum","plumb","plume","plump","plums","plumy","plunk","plus","plush","pluto","ply","poach","pod","podia","pods","poe","poem","poems","poet","poets","point","poise","poke","poked","poker","pokes","poky","polar","pole","poled","poles","polio","polka","poll","polls","polo","poly","polyp","pomp","pond","ponds","pony","pooch","pooh","pool","pools","poona","poop","poor","pop","pope","popes","poppy","pops","porch","pore","pored","pores","porgy","pork","porno","port","ports","pose","posed","poser","poses","posh","posit","posse","post","posts","posy","pot","pots","potty","pouch","pound","pour","pours","pout","pouts","pow","power","pps","pram","prams","prank","prat","prawn","pray","prays","pre","preen","prep","press","prey","preys","price","prick","pride","pried","pries","prig","prim","prime","print","prior","pris","prism","privy","prize","pro","probe","prod","prods","prof","prom","prone","prong","proof","prop","props","pros","prose","proud","prove","provo","prow","prowl","prows","proxy","prude","prune","pry","psalm","psion","psych","pub","pubs","puck","pucks","pudgy","puff","puffs","puffy","pug","puis","puke","puked","pukes","pull","pulls","pulp","pulps","pulpy","pulse","puma","pump","pumps","pun","punch","punic","punk","punks","puns","punt","punts","puny","pup","pupae","pupil","puppy","pups","pure","puree","purer","purge","purl","purls","purr","purrs","purse","pus","push","pushy","puss","pussy","put","puts","putt","putts","putty","pygmy","pylon","pyre","pyres","qatar","qdos","qed","qimi","qjump","qls","qmon","qpac","qptr","qram","qtyp","quack","quad","quads","quae","quaff","quail","quake","quaky","qualm","quark","quart","quash","quasi","quay","quays","queen","queer","quell","query","quest","queue","quick","quid","quiet","quiff","quill","quilt","quip","quips","quire","quirk","quit","quite","quito","quits","quiz","quoit","quota","quote","rabat","rabbi","rabid","race","raced","racer","races","rack","racks","racy","radar","radii","radio","radix","radon","raft","rafts","rag","rage","raged","rages","rags","raid","raids","rail","rails","rain","rains","rainy","raise","raja","rajah","rake","raked","rakes","rally","ralph","ram","ramp","ramps","rams","ran","ranch","rand","randy","rang","range","rangy","rank","ranks","rant","rants","rap","rape","raped","rapes","rapid","raps","rapt","rare","rarer","rash","rasp","rasps","rat","rate","rated","rates","ratio","rats","rave","raved","ravel","raven","raver","raves","raw","ray","rayed","rayon","rays","raze","razed","razes","razor","reach","react","read","reads","ready","real","realm","ream","reams","reap","reaps","rear","rears","rebel","rebus","rebut","recap","recur","red","redo","reds","reed","reeds","reedy","reef","reefs","reek","reeks","reel","reels","ref","refer","refit","regal","reign","rein","reins","relax","relay","relic","rely","remit","renal","rend","rends","renee","renew","rent","rents","rep","repay","repel","reply","rerun","resat","reset","resin","resit","rest","rests","retch","retry","reuse","rev","revel","revs","revue","rex","rhine","rhino","rhode","rhone","rhyme","rial","rib","ribs","rice","rices","rich","rick","ricky","rid","ride","rider","rides","ridge","rids","rife","rifer","rifle","rift","rifts","rig","riga","right","rigid","rigor","rigs","rile","rim","rims","rind","rinds","ring","rings","rink","rinks","rinse","rio","riot","riots","rip","ripe","ripen","rips","rise","risen","riser","rises","risk","risks","risky","rite","rites","ritz","rival","riven","river","rivet","riyal","roach","road","roads","roam","roams","roan","roar","roars","roast","rob","robe","robed","robes","robin","robot","robs","roc","rock","rocks","rocky","rod","rode","rodeo","rods","roe","roes","roger","rogue","rohr","role","roles","roll","rolls","rom","roman","rome","romeo","romp","romps","roof","roofs","rook","rooks","room","rooms","roomy","roost","root","roots","rope","roped","ropes","ropy","rose","roses","rosy","rot","rota","rote","rotor","rots","rouen","rouge","rough","round","rouse","rout","route","routs","rove","roved","rover","roves","row","rowan","rowdy","rowed","rower","rows","roy","royal","rub","rubs","ruby","ruck","rucks","ruddy","rude","ruder","rue","rued","rues","ruff","ruffs","rug","rugby","rugs","ruin","ruing","ruins","rule","ruled","ruler","rules","rum","rumba","rummy","rumor","rump","rumps","run","rune","runes","rung","rungs","runic","runny","runs","rupee","rural","ruse","ruses","rush","rusk","rusks","rust","rusts","rusty","rut","ruth","ruts","rutty","ryan","rye","saber","sable","sabot","sacci","sack","sacks","sad","sadly","safe","safer","safes","sag","saga","sagas","sage","sages","sago","sags","said","sail","sails","saint","sake","sakes","salad","sale","sales","salic","sally","salon","salt","salts","salty","salve","salvo","sam","samba","same","samoa","sand","sands","sandy","sane","saner","sang","sank","santa","sap","sappy","saps","sara","sarah","sari","saris","sash","sat","satan","sate","sated","sates","satin","sauce","saucy","saudi","saul","sauna","saute","save","saved","saver","saves","savor","savoy","savvy","saw","sawed","sawn","saws","saxon","say","says","scab","scabs","scald","scale","scalp","scaly","scam","scamp","scams","scan","scans","scant","scar","scare","scarf","scars","scary","scene","scent","scion","scire","scoff","scold","scone","scoop","scoot","scope","score","scorn","scot","scots","scott","scour","scout","scow","scowl","scows","scram","scrap","screw","scrip","scrub","scrum","scuba","scud","scuff","scull","scum","scup","scurf","scut","sea","seal","seals","seam","seams","seamy","sean","sear","sears","seas","seat","seato","seats","sec","sect","sects","sedan","seder","see","seed","seeds","seedy","seek","seeks","seem","seems","seen","seep","seeps","seer","seers","sees","seine","seize","self","sell","sells","semen","semi","send","sends","sense","sent","seoul","sepal","sepia","sere","serf","serfs","serge","serif","serum","serve","servo","set","seth","sets","setup","seven","sever","sew","sewed","sewer","sewn","sews","sex","sexed","sexes","sexy","shack","shade","shady","shaft","shag","shah","shake","shaky","shall","sham","shame","shams","shane","shank","shape","shard","share","shark","sharp","shave","shaw","shawl","she","she'd","sheaf","shear","shed","sheds","sheen","sheep","sheer","sheet","sheik","shelf","shell","shied","shier","shies","shift","shim","shin","shine","shins","shiny","ship","ships","shire","shirk","shirt","shoal","shock","shod","shoe","shoes","shone","shoo","shook","shoot","shop","shops","shore","shorn","short","shot","shots","shout","shove","show","shown","shows","showy","shred","shrew","shrub","shrug","shun","shuns","shunt","shut","shuts","shy","shyer","shyly","sibyl","sic","sick","side","sided","sides","sidle","siege","sieve","sift","sifts","sigh","sighs","sight","sigma","sign","signs","sikh","sikhs","silk","silks","silky","sill","sills","silly","silo","silos","silt","silts","silty","simon","sin","sinai","since","sine","sinew","sing","singe","singh","sings","sink","sinks","sins","sinus","sioux","sip","sips","sir","sire","sired","siren","sires","sirs","sisal","sissy","sit","site","sited","sites","sits","situ","six","sixes","sixth","sixty","size","sized","sizes","skate","skeet","skein","skew","skews","ski","skid","skids","skied","skier","skies","skiff","skill","skim","skimp","skims","skin","skins","skip","skips","skirt","skis","skit","skits","skive","skulk","skull","skunk","sky","slab","slabs","slack","slag","slags","slain","slake","slam","slams","slang","slant","slap","slaps","slash","slat","slate","slats","slav","slave","slay","slays","sled","sleds","sleek","sleep","sleet","slept","slew","slice","slick","slid","slide","slim","slime","slims","slimy","sling","slink","slip","slips","slit","slits","slob","sloe","slog","slogs","sloop","slop","slope","slops","slosh","slot","sloth","slots","slow","slows","slug","slugs","slum","slump","slums","slung","slunk","slur","slurp","slurs","slush","slut","sluts","sly","slyer","slyly","smack","small","smart","smash","smear","smell","smelt","smile","smirk","smite","smith","smock","smog","smoke","smoky","smote","smug","smut","snack","snag","snags","snail","snake","snaky","snap","snaps","snare","snark","snarl","sneak","sneer","snick","snide","sniff","snip","snipe","snips","snob","snobs","snood","snoop","snore","snort","snout","snow","snows","snowy","snub","snubs","snuff","snug","soak","soaks","soap","soaps","soapy","soar","soars","sob","sober","sobs","sock","socks","sod","soda","sods","sofa","sofas","sofia","soft","soggy","soil","soils","solar","sold","sole","soles","solet","solid","solo","solos","solve","some","somme","son","sonar","song","songs","sonic","sonny","sons","sony","soon","soot","sooty","sop","soppy","sops","sore","sorer","sores","sorry","sort","sorts","sot","soul","souls","sound","soup","soups","soupy","sour","sours","souse","south","sow","sowed","sower","sown","sows","soy","soya","spa","space","spade","spain","span","spank","spans","spar","spare","spark","spars","spas","spasm","spat","spate","spats","spawn","speak","spear","spec","speck","sped","speed","spell","spelt","spend","spent","sperm","spew","spews","spice","spicy","spied","spies","spike","spiky","spill","spilt","spin","spine","spins","spiny","spire","spit","spite","spits","splay","split","spoil","spoke","spoof","spook","spool","spoon","spoor","spore","sport","spot","spots","spout","sprat","spray","spree","sprig","spry","spud","spuds","spun","spunk","spur","spurn","spurs","spurt","spy","squab","squad","squat","squaw","squib","squid","sse","ssw","stab","stabs","stack","staff","stag","stage","stags","staid","stain","stair","stake","stale","stalk","stall","stamp","stan","stand","stank","star","stare","stark","stars","start","stary","stash","state","stave","stay","stays","std","stead","steak","steal","steam","steed","steel","steep","steer","stele","stem","stems","step","steps","stern","stet","steve","stew","stews","stick","sties","stiff","stile","still","stilt","sting","stink","stint","stir","stirs","stoat","stock","stoic","stoke","stole","stomp","stone","stony","stood","stool","stoop","stop","stops","store","stork","storm","story","stout","stove","stow","stows","strap","straw","stray","strew","strip","strop","strum","strut","stub","stubs","stuck","stud","studs","study","stuff","stump","stun","stung","stunk","stuns","stunt","sty","style","styli","styx","sua","suave","sub","subs","such","suck","sucks","sudan","suds","sue","sued","suede","sues","suet","suez","sugar","suing","suit","suite","suits","sulfa","sulk","sulks","sulky","sully","sum","sums","sun","sung","sunk","sunny","suns","sunup","sup","super","supra","sups","sure","surf","surge","surly","susan","sushi","suus","swab","swabs","swag","swain","swam","swamp","swan","swank","swans","swap","swaps","swarm","swat","swath","swats","sway","sways","swear","sweat","swede","sweep","sweet","swell","swelt","swept","swift","swig","swill","swim","swims","swine","swing","swipe","swirl","swish","swiss","swoon","swoop","swop","swops","sword","swore","sworn","swum","swung","sylph","sync","synod","syria","syrup","tab","tabby","table","taboo","tabs","tacit","tack","tacks","tacky","tact","tacts","taffy","tag","tags","taiga","tail","tails","taint","take","taken","taker","takes","talas","talc","tale","tales","talk","talks","talky","tall","tally","talon","tam","tame","tamed","tamer","tames","tamil","tamp","tampa","tamps","tan","tang","tango","tangs","tangy","tank","tanks","tans","tansy","taos","tap","tape","taped","taper","tapes","tapir","taps","tar","tardy","tarns","taro","tarry","tars","tart","tarts","task","tasks","taste","tasty","tat","tatty","taunt","taut","tawny","tax","taxed","taxes","taxi","taxis","tea","teach","teak","teal","teals","team","teams","tear","tears","teas","tease","teat","teats","ted","teddy","tee","teem","teems","teen","teens","teeny","tees","teet","teeth","tel","tele","telex","tell","tells","temp","tempo","temps","tempt","ten","tench","tend","tends","tenet","tenor","tens","tense","tent","tenth","tents","tepid","term","terms","tern","terns","terra","terry","terse","test","tests","testy","texan","texas","text","texts","thai","than","thane","thank","that","thaw","thaws","the","theca","theft","their","them","theme","then","there","these","theta","they","thick","thief","thigh","thin","thing","think","third","this","thong","thorn","those","three","threw","throb","throe","throw","thud","thuds","thug","thugs","thumb","thump","thus","thyme","tiara","tiber","tibet","tibia","tic","tick","ticks","tics","tidal","tide","tides","tidy","tie","tied","tier","tiers","ties","tiff","tiffs","tiger","tight","tilde","tile","tiled","tiler","tiles","till","tills","tilt","tilth","tilts","tim","time","timed","timer","times","timex","timid","timor","tin","tina","tine","tinge","tinny","tins","tint","tints","tiny","tip","tips","tipsy","tire","tired","tires","tit","titan","tithe","title","tits","titus","tnt","toad","toads","toady","toast","today","todd","toddy","toe","toed","toes","tofu","tog","toga","togo","togs","toil","toils","token","tokyo","told","toll","tolls","tom","tomb","tombs","tome","tomes","tommy","ton","tonal","tone","toned","toner","tones","tong","tonga","tongs","tonic","tons","tony","too","took","tool","tools","toot","tooth","toots","top","topaz","tope","topic","tops","topsy","torah","torch","tore","torn","torso","tort","torus","tory","tosco","toss","tot","total","tote","toted","totem","totes","touch","tough","tour","tours","tout","touts","tow","towed","towel","tower","town","towns","tows","toxic","toxin","toy","toyed","toys","trace","track","tract","tracy","trade","trail","train","trait","tram","tramp","trams","trap","traps","trash","trawl","tray","trays","tread","treat","tree","trees","trek","treks","trend","tress","triad","trial","tribe","trice","trick","tried","tries","trill","trim","trims","trio","trios","trip","tripe","trips","trite","trod","troll","troop","trot","troth","trots","trout","trove","troy","truce","truck","true","truer","trues","truly","trump","trunk","truss","trust","truth","try","tryst","tub","tuba","tubas","tubby","tube","tuber","tubes","tubs","tuck","tucks","tudor","tuft","tufts","tufty","tug","tugs","tulip","tulsa","tummy","tumor","tun","tuna","tunc","tune","tuned","tuner","tunes","tunic","tunis","tunny","tuns","turbo","turf","turfs","turin","turk","turks","turn","turns","turvy","tusk","tusks","tutee","tutor","tutu","twain","twang","tweak","tweed","tweet","twice","twig","twigs","twill","twin","twine","twins","twirl","twist","twit","twits","two","twos","tying","tyler","type","typed","types","typo","tyrol","tyros","tyson","tythe","tzar","tzars","udder","ufo","ugh","ugly","ukase","ulcer","ultra","umber","unapt","unarm","unary","unbar","unbid","uncap","uncle","uncut","under","undid","undo","undue","unfed","unfit","unify","union","unit","unite","units","unity","unix","unman","unpeg","unpin","unsay","unset","untie","until","unto","unwed","unzip","upon","upped","upper","ups","upset","urban","urdu","urge","urged","urges","uric","urine","urn","urns","usa","usage","use","used","user","users","uses","usher","using","ussr","usual","usurp","usury","utah","uteri","utter","uvula","uzbek","vaduz","vague","vain","vale","vales","valet","valid","valor","value","valve","vamp","vamps","van","vane","vaned","vanes","vans","vapid","vapor","vary","vase","vases","vast","vat","vats","vault","vaunt","veal","veer","veers","vegan","veil","veils","vein","veins","vela","velum","venal","vend","vends","venia","venom","vent","vents","venue","venus","verb","verba","verbs","verdi","verge","versa","verse","verve","very","vest","vests","vet","veto","vets","vex","vexed","vexes","via","vials","vibes","vic","vicar","vice","vices","vicki","video","vie","vied","vies","view","views","vigil","vigor","vile","viler","villa","vim","vine","vines","vinyl","viol","viola","viols","viper","viral","virgo","virus","vis","visa","visas","visit","visor","vista","vital","vitas","vitro","viva","vivid","vixen","viz","vocal","vodka","vogue","voice","void","voids","vole","voles","volt","volta","volts","volvo","vomit","vote","voted","voter","votes","vouch","vow","vowed","vowel","vows","vox","vulva","vying","wad","wade","waded","wader","wades","wads","wafer","waft","wafts","wag","wage","waged","wager","wages","wagon","wags","waif","wail","wails","wain","waist","wait","waits","waive","wake","waked","waken","wakes","wales","walk","walks","wall","walls","wally","waltz","wan","wand","wands","wane","waned","wanes","wanly","want","wants","war","ward","wards","ware","wares","warm","warms","warn","warns","warp","warps","wars","wart","warts","warty","wary","was","wash","washy","wasp","wasps","waste","watch","water","watt","watts","wave","waved","waver","waves","wavy","wax","waxed","waxen","waxes","waxy","way","ways","we'd","we'll","we're","we've","weak","weal","weals","wean","weans","wear","wears","weary","weave","web","webs","wed","wedge","weds","wee","weed","weeds","weedy","week","weeks","weeny","weep","weeps","weepy","weft","weigh","weir","weird","weirs","weld","welds","well","wells","welsh","welt","welts","wen","wench","wend","wends","went","wept","were","west","wet","wetly","wets","whack","whale","wham","wharf","what","wheat","wheel","whelk","when","where","whet","whets","whew","whey","which","whiff","whig","while","whim","whims","whine","whiny","whip","whips","whir","whirl","whisk","whist","whit","white","whiz","who","whoa","whole","whom","whoop","whore","whorl","whose","why","whys","wick","wicks","wide","widen","wider","widow","width","wield","wife","wig","wigs","wild","wilds","wile","wiles","will","wills","wilt","wilts","wily","wimp","wimps","win","wince","winch","wind","winds","windy","wine","wined","wines","wing","wings","wink","winks","wino","wins","winy","wipe","wiped","wiper","wipes","wire","wired","wires","wiry","wise","wised","wiser","wish","wishy","wisp","wisps","wispy","wit","witch","with","wits","witty","wives","wizen","wnw","woe","woes","wok","woke","woken","wolf","wolfs","woman","womb","wombs","women","won","won't","wont","woo","wood","woods","woody","wooed","wooer","woof","wool","woos","word","words","wordy","wore","work","works","world","worm","worms","wormy","worn","worry","worse","worst","worth","would","wound","wove","woven","wow","wowed","wrack","wraf","wrap","wraps","wrath","wreak","wreck","wren","wrens","wrest","wrier","wring","wrist","writ","write","writs","wrong","wrote","wroth","wrung","wry","wryly","wsw","xenon","xerox","xii","xiii","xiv","xix","xmas","xray","xrays","xvi","xvii","xviii","xxi","xxii","xxiii","xxiv","xxix","xxv","xxvi","xxvii","xxx","yacht","yahoo","yak","yaks","yale","yalta","yam","yams","yang","yank","yanks","yap","yaps","yard","yards","yarn","yarns","yaw","yawed","yawl","yawls","yawn","yawns","yaws","yeah","year","yearn","years","yeas","yeast","yell","yells","yelp","yelps","yemen","yen","yes","yet","yeti","yetis","yew","yews","yid","yield","yin","ymca","yodel","yoga","yogi","yoke","yoked","yokel","yokes","yolk","yolks","yolky","yom","yon","yore","york","you","you'd","young","your","yours","youth","yoyo","yoyos","yuan","yukon","yule","yummy","ywca","zaire","zany","zap","zaps","zeal","zebra","zebu","zees","zen","zero","zeros","zest","zesty","zeus","zinc","zion","zip","zippy","zips","zloty","zonal","zone","zoned","zones","zoo","zoom","zooms","zoos"]
      Rn = Math.random

      for(m=2;m--;) setTimeout(()=>{
        mirrorsIframe.src = 'mirrors'
      },250*(m+1))
      if(1)setInterval(()=>{
        mirrorsIframe.src = 'mirrors'
      },9500)
      openPracticeFrame = tgt => {
        practiceContainer.innerHTML = ''
        let practiceFrame = document.createElement('iframe')
        practiceFrame.className = 'practiceFrame'
        practiceFrame.src = tgt
        practiceContainer.appendChild(practiceFrame)
        returnButton.style.display = 'block'
      }

      genGameKey = () =>{
        tokens = []
        for(let i=3;i--;){
          do{
            newToken = shortWords[Rn()*shortWords.length|0]
          }while(tokens.filter(v=>v===newToken).length);
          tokens = [...tokens, newToken]
        }
        return tokens.join(' ')
      }
      
      br = () => document.createElement('br')
      
      hideModals = () => {
        modals = document.querySelectorAll('.modal').forEach(el=>{
          el.style.display = 'none'
        })
      }
      
      loadButton = (buttonData, fromModal=false) => {
        let button = document.createElement('button')
        button.className = 'button'
        let buttonContent = document.createElement('div')
        buttonContent.className = 'gameThumbs'
        buttonContent.id = buttonData.content.thumbId
        if(fromModal){
          button.style.transform = 'scale(2)'
        }else{
          buttonContent.onclick = e => {
            e.preventDefault()
            e.stopPropagation()
            popupButton(buttonData)
          }
        }
        button.appendChild(buttonContent)
        button.appendChild(br())
        captionContainer = document.createElement('div')
        captionContainer.className = 'captionContainer'
        captionContainer.style.background = '#804'
        captionContainer.title = "practice\n" + buttonData.captionsPractice[0]
        buttonData.captionsPractice.map((caption, idx) => {
          let el = document.createElement('div')
          el.className = 'captionPractice'
          el.innerHTML = caption
          captionContainer.appendChild(el)
          if(idx<buttonData.captionsPractice.length-1) captionContainer.appendChild(br())
        })
        captionContainer.onclick = e => {
          e.preventDefault()
          e.stopPropagation()
          openPracticeFrame(buttonData.practiceFrameTgt)
          hideModals()
        }
        button.appendChild(captionContainer)

        captionContainer = document.createElement('div')
        captionContainer.className = 'captionContainer'
        captionContainer.style.background = '#086'
        captionContainer.style.marginTop = '10px;'
        buttonData.captionsLive.map(caption=>{
          let el = document.createElement('div')
          el.title = 'launch a\nMULTIPLAYER ARENA\nfor ' + buttonData.captionsPractice[0]
          el.className = 'captionLive'
          el.innerHTML = caption
          captionContainer.appendChild(el)
        })
        captionContainer.onclick = e => {
          let link = document.createElement('a')
          link.target = '_blank'
          link.href = buttonData.liveLink
          link.style.position = 'fixed'
          link.style.visibility = 'hidden'
          document.body.appendChild(link)
          link.click()
          link.remove()
          hideModals()
        }
        button.appendChild(captionContainer)
        return button
      }

      popupButton = buttonData => {
        buttonModal.innerHTML = ''
        buttonModal.appendChild(loadButton(buttonData, true))
        buttonModal.style.display = 'flex'
      }

      loadButtons = () => {
        practiceContainer.innerHTML = ''
        buttonData = [
          {
            practiceFrameTgt: 'tictactoe_practice',
            content: {
              thumbId: 'tictactoeThumb',
            },
            captionsPractice:[
              'TIC TAC TOE',
              '<span style="font-size: 1.5em;">PRACTICE</span>',
              ,'',
            ],
            captionsLive:[
              '<span style="font-size: 1.5em"> ARENA </span>'
            ],
            liveLink: '/launch/?gamesel=tictactoe'
          },
          {
            practiceFrameTgt: 'tetris_practice',
            content: {
              thumbId: 'tetrisThumb',
            },
            captionsPractice:[
              'TETRIS',
              '<span style="font-size: 1.5em;">PRACTICE</span>',
              '',
            ],
            captionsLive:[
              '<span style="font-size: 1.5em"> ARENA </span>'
            ],
            liveLink: '/launch/?gamesel=tetris'
          },
          {
            practiceFrameTgt: 'orbs_practice',
            content: {
              thumbId: 'orbsThumb',
            },
            captionsPractice:[
              'ORBS',
              '<span style="font-size: 1.5em;">PRACTICE</span>',
              ,'',
            ],
            captionsLive:[
              '<span style="font-size: 1.5em"> ARENA </span>'
            ],
            liveLink: '/launch/?gamesel=orbs'
          },
          {
            practiceFrameTgt: 'sidetoside_practice',
            content: {
              thumbId: 'sideToSideThumb',
            },
            captionsPractice:[
              'SIDE TO SIDE',
              '<span style="font-size: 1.5em;">PRACTICE</span>',
              ,'',
            ],
            captionsLive:[
              '<span style="font-size: 1.5em"> ARENA </span>'
            ],
            liveLink: '/launch/?gamesel=sidetoside'
          },
          {
            practiceFrameTgt: 'puyopuyo_practice',
            content: {
              thumbId: 'puyopuyoThumb',
            },
            captionsPractice:[
              'PUYO PUYO',
              '<span style="font-size: 1.5em;">PRACTICE</span>',
              ,'',
            ],
            captionsLive:[
              '<span style="font-size: 1.5em"> ARENA </span>'
            ],
            liveLink: '/launch/?gamesel=puyopuyo'
          },
          {
            practiceFrameTgt: 'battleracer_practice',
            content: {
              thumbId: 'battleracerThumb',
            },
            captionsPractice:[
              'PUYO PUYO',
              '<span style="font-size: 1.5em;">PRACTICE</span>',
              ,'',
            ],
            captionsLive:[
              '<span style="font-size: 1.5em"> ARENA </span>'
            ],
            liveLink: '/launch/?gamesel=battleracer'
          },
        ]
        for(m=1;m--;)buttonData.map(buttonData => {
          practiceContainer.appendChild( loadButton(buttonData, false) )
        })
      }
      loadButtons()
      
      returnToGames = () => {
        returnButton.style.display = 'none'
        loadButtons()
      }
      
      console.log(genGameKey())
    </script>
  </body>
</html>
FILE;

file_put_contents('../index.php', $file);

$file = <<<'FILE'
<?php
  require('db.php');

  $sql = "SELECT unix_timestamp()";
  $res = mysqli_query($link, $sql);
  $row = mysqli_fetch_assoc($res);
  $time = $row['unix_timestamp()'];

  function decToAlpha($val){
    $alphabet="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $ret="";
    while($val){
      $r=floor($val/62);
      $frac=$val/62-$r;
      $ind=(int)round($frac*62);
      $ret=$alphabet[$ind].$ret;
      $val=$r;
    }
    return $ret==""?"0":$ret;
  }

  function alphaToDec($val){
    $pow=0;
    $res=0;
    while($val!=""){
      $cur=$val[strlen($val)-1];
      $val=substr($val,0,strlen($val)-1);
      $mul=ord($cur)<58?$cur:ord($cur)-(ord($cur)>96?87:29);
      $res+=$mul*pow(62,$pow);
      $pow++;
    }
    return $res;
  }
  
  function status($row){
    $port_     = '3306';
    $db_       = $row['cred'];
    $db_user_  = $row['user'];
    $db_host_  = $row['server'];
    $db_pass_  = $row['pass'];
    $link_     = mysqli_connect($db_host_,$db_user_,$db_pass_,$db_,$port_);
    $sql_      = "SELECT * FROM orbsMirrors";
    $res_      = mysqli_query($link_, $sql_);
    $ret       = !!$res_;
    mysqli_close($link_);
    return $ret;
  }

  $sql = "SELECT * FROM orbsMirrors";
  $res = mysqli_query($link, $sql);
  
  if(mysqli_num_rows($res)){
    $liveCount = 0;
    $servers = [];
    $states = [];
    for($i = 0; $i < mysqli_num_rows($res); ++$i){
      $row = mysqli_fetch_assoc($res);
      if(!!intval($row['active'])){
        $servers[] = $row;
        $serverState = status($row);
        if($serverState) $liveCount++;
        $states[] = $serverState;
      }
    }
    
    if($liveCount){
      
      $gameTables = [
        'tic tac toe'  => 'tictactoeGames',
        'tetris'       => 'tetrisGames',
        'orbs'         => 'platformGames',
        'side to side' => 'sideToSideGames',
        'puyopuyo'     => 'puyopuyoGames',
        'battleracer'  => 'battleracerGames',
      ];
      
      $liveGames = [];
      for($idx = 0; $idx < sizeof($servers); ++$idx){
        if($states[$idx]){
          $server        = $servers[$idx];
          $game_db_user  = $server['user'];
          $game_db_pass  = $server['pass'];
          $game_db_host  = $server['server'];
          $game_db       = $server['cred'];
          $game_port     = '3306';
          $game_link     = mysqli_connect($game_db_host,$game_db_user,$game_db_pass,$game_db,$game_port);
          forEach($gameTables as $key=>$val){
            $sql = "SELECT * FROM " . $val;
            $res = mysqli_query($game_link, $sql);
            $slug = '';
            if(mysqli_num_rows($res)){
              $row = mysqli_fetch_assoc($res);
              $lastUpdate = 0;
              $numberPlayers = 0;
              $gameFull = false;
              $tData = '';
              $gameMaster = '';
              switch($key){
                case 'tic tac toe':
                  $icon = 'tictactoe.png';
                  $data = $row;
                  if($data['data']){
                    $gameID = $data['id'];
                    $slug = decToAlpha($gameID);
                    $sql = "SELECT name, id FROM tictactoeSessions WHERE gameID = $gameID";
                    $res2 = mysqli_query($game_link, $sql);
                    if(mysqli_num_rows($res2)){
                      $row2 = mysqli_fetch_assoc($res2);
                      $gameMaster = $row2['name'];
                      $gmid = $row2['id'];
                    }else{
                      $gameMaster = '[absent]';
                    }
                    $tData = json_decode($data['data']);
                    $players = $tData->{'players'};
                    $numberPlayers = 0;
                    $lastUpdate = 0;
                    forEach($players as $player){
                      forEach($player as $key2=>$val2){
                        if($key2 == 'time'){
                          $numberPlayers++;
                          $lu = $val2;
                          if($lu > $lastUpdate) $lastUpdate = $lu;
                        }
                      }
                    }
                  }
                  if($numberPlayers >= 2) $gameFull = true;
                  $gameLink = $server['actualURL'] . "tictactoe/g/?g=$slug&gmid=$gmid";
                break;
                case 'tetris':
                  $icon = '1XXD2f.png';
                  $data = $row;
                  $gameID = $row['id'];
                  $slug = decToAlpha($gameID);
                  if($data['gamedataA']){
                    $numberPlayers++;
                    $tDataA = json_decode($data['gamedataA']);
                    $gameMaster = $tDataA->{'playerName'};
                    $lu = $tDataA->{'lastUpdate'};
                    if($lu > $lastUpdate) $lastUpdate = $lu;
                  }
                  if($data['gamedataB']){
                    $numberPlayers++;
                    $tDataB = json_decode($data['gamedataB']);
                    $lu = $tDataB->{'lastUpdate'};
                    if($lu > $lastUpdate) $lastUpdate = $lu;
                  }
                  if($data['gamedataC']){
                    $numberPlayers++;
                    $tDataC = json_decode($data['gamedataC']);
                    $lu = $tDataC->{'lastUpdate'};
                    if($lu > $lastUpdate) $lastUpdate = $lu;
                  }
                  if($data['gamedataD']){
                    $numberPlayers++;
                    $tDataD = json_decode($data['gamedataD']);
                    $lu = $tDataD->{'lastUpdate'};
                    if($lu > $lastUpdate) $lastUpdate = $lu;
                  }
                  if($numberPlayers >= 4) $gameFull = true;
                  $gameLink = $server['actualURL'] . "tetris?i=/game/$slug/";
                break;
                case 'orbs':
                  $icon = 'burst.png';
                  $data = $row;
                  if($data['data']){
                    $gameID = $data['id'];
                    $slug = decToAlpha($gameID);
                    $sql = "SELECT name, id FROM platformSessions WHERE gameID = $gameID";
                    $res2 = mysqli_query($game_link, $sql);
                    if(mysqli_num_rows($res2)){
                      $row2 = mysqli_fetch_assoc($res2);
                      $gameMaster = $row2['name'];
                      $gmid = $row2['id'];
                    }else{
                      $gameMaster = '[absent]';
                    }
                    $tData = json_decode($data['data']);
                    $players = $tData->{'players'};
                    $numberPlayers = 0;
                    $lastUpdate = 0;
                    forEach($players as $player){
                      forEach($player as $key2=>$val2){
                        if($key2 == 'time'){
                          $numberPlayers++;
                          $lu = $val2;
                          if($lu > $lastUpdate) $lastUpdate = $lu;
                        }
                      }
                    }
                  }
                  if($numberPlayers >= 4) $gameFull = true;
                  $gameLink = $server['actualURL'] . "orbs/%CE%94/?g=$slug&gmid=$gmid";
                break;
                case 'side to side':
                  $icon = 'sideToSideThumb.png';
                  $data = $row;
                  if($data['data']){
                    $gameID = $data['id'];
                    $slug = decToAlpha($gameID);
                    $sql = "SELECT name, id FROM sideToSideSessions WHERE gameID = $gameID";
                    $res2 = mysqli_query($game_link, $sql);
                    if(mysqli_num_rows($res2)){
                      $row2 = mysqli_fetch_assoc($res2);
                      $gameMaster = $row2['name'];
                      $gmid = $row2['id'];
                    }else{
                      $gameMaster = '[absent]';
                    }
                    $tData = json_decode($data['data']);
                    $players = $tData->{'players'};
                    $numberPlayers = 0;
                    $lastUpdate = 0;
                    forEach($players as $player){
                      forEach($player as $key2=>$val2){
                        if($key2 == 'time'){
                          $numberPlayers++;
                          $lu = $val2;
                          if($lu > $lastUpdate) $lastUpdate = $lu;
                        }
                      }
                    }
                  }
                  if($numberPlayers >= 2) $gameFull = true;
                  $gameLink = $server['actualURL'] . "sidetoside/g/?g=$slug&gmid=$gmid";
                break;
                case 'puyopuyo':
                  $icon = 'puyopuyoThumb.png';
                  $data = $row;
                  if($data['data']){
                    $gameID = $data['id'];
                    $slug = decToAlpha($gameID);
                    $sql = "SELECT name, id FROM puyopuyoSessions WHERE gameID = $gameID";
                    $res2 = mysqli_query($game_link, $sql);
                    if(mysqli_num_rows($res2)){
                      $row2 = mysqli_fetch_assoc($res2);
                      $gameMaster = $row2['name'];
                      $gmid = $row2['id'];
                    }else{
                      $gameMaster = '[absent]';
                    }
                    $tData = json_decode($data['data']);
                    $players = $tData->{'players'};
                    $numberPlayers = 0;
                    $lastUpdate = 0;
                    forEach($players as $player){
                      forEach($player as $key2=>$val2){
                        if($key2 == 'time'){
                          $numberPlayers++;
                          $lu = $val2;
                          if($lu > $lastUpdate) $lastUpdate = $lu;
                        }
                      }
                    }
                  }
                  if($numberPlayers >= 2) $gameFull = true;
                  $gameLink = $server['actualURL'] . "puyopuyo/g/?g=$slug&gmid=$gmid";
                break;
              }
              $diff = $time - $lastUpdate;
              if($diff>60){
                $sql = "DELETE FROM $val WHERE id = $gameID";
                mysqli_query($game_link, $sql);
              }else{
                if($numberPlayers && $lastUpdate){
                  $liveGames[] = [
                    'icon'          => $icon,
                    'game'          => $key,
                    'OP'            => $gameMaster,
                    'users'         => $numberPlayers,
                    //'lastUpdate'    => $lastUpdate,
                    //'time'          => $time,
                    'diff'          => $diff,
                    //'gameID'        => $gameID,
                    //'server'        => $server['topURL'],
                    'gameFull'      => $gameFull,
                    'gameLink'      => $gameLink,
                    //'slug'          => $slug,
                    //'sizeof($servers)' => sizeof($servers),
                    //'idx'           => $idx
                  ];
                }
                case 'battleracer':
                  $icon = 'battleracerThumb.png';
                  $data = $row;
                  if($data['data']){
                    $gameID = $data['id'];
                    $slug = decToAlpha($gameID);
                    $sql = "SELECT name, id FROM battleracerSessions WHERE gameID = $gameID";
                    $res2 = mysqli_query($game_link, $sql);
                    if(mysqli_num_rows($res2)){
                      $row2 = mysqli_fetch_assoc($res2);
                      $gameMaster = $row2['name'];
                      $gmid = $row2['id'];
                    }else{
                      $gameMaster = '[absent]';
                    }
                    $tData = json_decode($data['data']);
                    $players = $tData->{'players'};
                    $numberPlayers = 0;
                    $lastUpdate = 0;
                    forEach($players as $player){
                      forEach($player as $key2=>$val2){
                        if($key2 == 'time'){
                          $numberPlayers++;
                          $lu = $val2;
                          if($lu > $lastUpdate) $lastUpdate = $lu;
                        }
                      }
                    }
                  }
                  if($numberPlayers >= 4) $gameFull = true;
                  $gameLink = $server['actualURL'] . "battleracer/g/?g=$slug&gmid=$gmid";
                break;
              }
              $diff = $time - $lastUpdate;
              if($diff>60){
                $sql = "DELETE FROM $val WHERE id = $gameID";
                mysqli_query($game_link, $sql);
              }else{
                if($numberPlayers && $lastUpdate){
                  $liveGames[] = [
                    'icon'          => $icon,
                    'game'          => $key,
                    'OP'            => $gameMaster,
                    'users'         => $numberPlayers,
                    //'lastUpdate'    => $lastUpdate,
                    //'time'          => $time,
                    'diff'          => $diff,
                    //'gameID'        => $gameID,
                    //'server'        => $server['topURL'],
                    'gameFull'      => $gameFull,
                    'gameLink'      => $gameLink,
                    //'slug'          => $slug,
                    //'sizeof($servers)' => sizeof($servers),
                    //'idx'           => $idx
                  ];
                }
              }
            }
          }
          mysqli_close($game_link);
        }
      }
    }
    
    $servers = json_encode($servers);
  }else{
    echo '[false]';
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>ARENA mirrors [updated: 11/27/23]</title>
    <style>
      /* latin-ext */
      @font-face {
        font-family: 'Courier Prime';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/courierprime/v9/u-450q2lgwslOqpF_6gQ8kELaw9pWt_-.woff2) format('woff2');
        unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
      }
      /* latin */
      @font-face {
        font-family: 'Courier Prime';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/courierprime/v9/u-450q2lgwslOqpF_6gQ8kELawFpWg.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
      }
      body, html{
        margin: 0;
        background: #000;
        color: #fff;
        font-family: Courier Prime;
        overflow-x: hidden;
        min-height: 100vh;
      }
      #title {
        padding: 20px;
        background: linear-gradient(90deg,#600, #000, #000);
        color: #fff;
        font-size: 3em;
        position: fixed;
        display: block;
        width: 100%;
        max-height: 46px;
        text-shadow: 3px 3px 3px #000;
        z-index: 1000;
      }
      .link{
        padding: 1px;
        border: none;
        display: inline-block;
        min-width: 300px;
        font-size: 1.25em;
        background: #40f8;
        color: #fff;
        text-decoration: none;
        margin: 20px;
        margin-bottom: 0;
        border: 10px solid #4f82;
        border-radius: 20px;
      }
      .gameLink{
        padding: 1px;
        border: none;
        display: inline-block;
        width: 300px;
        font-size: 1.25em;
        color: #fff;
        text-align: left;
        text-decoration: none;
        margin: 20px;
        margin-bottom: 0;
        border: 10px solid #48f2;
        border-radius: 20px;
      }
      .gameLinkItem{
        margin: 0px;
        display: block;
        color: #fff;
        display: inline-block;
      }
      #mirrorList{
        text-align: center;
        background: #111;
        position: absolute;
        right: 0;
        width: 50%;
        margin-top: 86px;
        min-height: calc(100vh - 86px);
      }
      #gamesList{
        text-align: center;
        background: linear-gradient(90deg, #400,#000);
        position: absolute;
        left: 0;
        width: 50%;
        margin-top: 86px;
        min-height: calc(100vh - 86px);
      }
      .caption{
        color: #888;
        font-size: .6em;
        margin-left: 20px;
        float: left;
      }
      .msgText{
        display: block;
        text-align: center;
        padding-top: 25px;
        font-size: 2em;
      }
      .statusDiv{
        background-size: 25px 25px;
        background-position: 5px center;
        background-repeat: no-repeat;
        display: inline-block;
        width: 260px;
        height: 30px;
        margin-bottom: 10px;
        padding-top: 9px;
      }
      .statusText{
        margin-left: 25px;
      }
      .gameLinkTitle{
        font-size: 2em;
      }
      .gameLinkIcon{
        width: 100px;
        height: 100px;
        float: right;
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        margin-top: 10px;
      }
    </style>
  </head>
  <body>
    <div id="title">ARENA GAMES</div>
    <div id="gamesList">
      <div class="msgText">
        LIVE GAMES
      </div>
    </div>
    <div id="mirrorList">
      <div class="msgText">
        SERVER STATUS
      </div>
    </div>
    <script>
      alphaToDec = val => {
        let pow=0
        let res=0
        let cur, mul
        while(val!=''){
          cur=val[val.length-1]
          val=val.substring(0,val.length-1)
          mul=cur.charCodeAt(0)<58?cur:cur.charCodeAt(0)-(cur.charCodeAt(0)>96?87:29)
          res+=mul*(62**pow)
          pow++
        }
        return res
      }
      decToAlpha = n => {
        let alphabet='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
        let ret='', r
        while(n){
          ret = alphabet[Math.round((n/62-(r=n/62|0))*62)|0] + ret
          n=r
        }
        return ret == '' ? '0' : ret
      }
      
      liveGames = JSON.parse('<?=json_encode($liveGames)?>')
      
      liveGames.sort((a,b)=>a.diff - b.diff)
      
      br = () => document.createElement('br')

      mirrorList = document.querySelector('#mirrorList')
      gamesList = document.querySelector('#gamesList')
      
      if(liveGames.length){
        liveGames.map((liveGame, idx) => {
          let container = document.createElement('div')
          container.className = 'gameLink'
          Object.entries(liveGame).forEach(([key, value]) => {
            if(key != 'diff'){
              if(key == 'gameFull'){
                container.style.background = value ? '#602' : '#062'
                if(!value){
                  container.style.cursor = 'pointer'
                  container.title = 'JOIN GAME!'
                  container.onclick = () => {
                  }
                }
              }
              let el = document.createElement('div')
              if(key == 'icon'){
                el.className = 'gameLinkIcon'
                el.style.backgroundImage = `url(${value})`
                container.appendChild(el)
              }else{
                if(key == 'game'){
                  el.className = 'gameLinkItem gameLinkTitle'
                  el.innerHTML = `${value}`
                }else{
                  if(key!='gameFull' || (key=='gameFull' && value)){
                    el.className = 'gameLinkItem'
                    if(key == 'gameLink'){
                      el.innerHTML = `${key} : <a target="_blank" href="${value}">link</a>`
                    }else{
                      el.innerHTML = `${key} : ${value}`
                    }
                  }
                }
                container.appendChild(el)
                if(key!='gameFull') container.appendChild(br())
              }
            }
          })
          gamesList.appendChild(container)
          setTimeout(() => {
            if(mirrorList.clientHeight < gamesList.clientHeight){
              mirrorList.style.height = gamesList.clientHeight + 'px'
            }
          },0)
        })
      }else{
        gamesList.innerHTML = `
          <div class="msgText">
            LIVE GAMES<hr><br><br>
            NO GAMES FOUND!<br><br><br>
            maybe you should<br>
            create one!<br><br>
            click<br>
            "<b>ARENA</b>"<br>
            on any of the games<br>
            shown in the practice area
          </div>`
      }
      
      links = JSON.parse('<?=$servers?>')
      completed = Array(links.length).fill(false)
      els = Array(links.length).fill(v=>{return {el: '', status: false}})
      function genStatus (v, i) {
        fetch(`status.php?url=${v.topURL}&server=${v.server}&pass=${v.pass}&db=${v.cred}&user=${v.user}`).then(res=>res.text()).then(data=>{
          data = data ? JSON.parse(data) : [false]
          let el = document.createElement('a')
          el.style.pointerEvents = 'none'
          // clicking disabled   ^
          el.className = 'link'
          el.target = '_blank'
          topURL = v.topURL.split('://')[1]
          actualURL = v.actualURL.split('://')[1]
          el.innerHTML = `mirror ${i+1}<br><span class="caption">[${topURL}]</span><br><span class="caption">[${actualURL}]</span>`
          el.href = v.topURL
          els[i] = [el, data[0]]
          completed[i] = true
          if(completed.filter(v=>v).length == completed.length){
            els.sort((a,b)=>b[1]-a[1])
            els.map(el=>{
              let statusEl = document.createElement('div')
              statusEl.className = 'statusDiv'
              statusEl.style.backgroundImage = el[1] ? 'url(check.png)' : 'url(x.png)'
              statusEl.style.backgroundColor = el[1] ? '#084' : '#400'
              statusEl.style.color = el[1] ? '#0f8' : '#f00'
              statusEl.innerHTML = '<span class="statusText">' + (el[1] ? 'connected / online' : 'ruh roh / problems') + '</span>'
              br = document.createElement('br')
              el[0].appendChild(br)
              el[0].appendChild(statusEl)
              br = document.createElement('br')
              mirrorList.appendChild(el[0])
              mirrorList.appendChild(br)
              setTimeout(() => {
                if(gamesList.clientHeight < mirrorList.clientHeight){
                  gamesList.style.height = mirrorList.clientHeight + 'px'
                }
              },0)
            })
          }
        })
      }
      links.map((v, i) => {
        genStatus(v,i)
      })
      if(1)setTimeout(()=>{
        location.reload()
      }, 10000)
      
    </script>
  </body>
</html>
FILE;

file_put_contents('../mirrors/index.php', $file);

$file = <<<'FILE'
<?php
  require('db.php');
  
  function status($row){
    $port_     = '3306';
    $db_       = $row['cred'];
    $db_user_  = $row['user'];
    $db_host_  = $row['server'];
    $db_pass_  = $row['pass'];
    $link_     = mysqli_connect($db_host_,$db_user_,$db_pass_,$db_,$port_);
    $sql_      = 'SELECT * FROM orbsMirrors';
    $res_      = mysqli_query($link_, $sql_);
    mysqli_close($link_);
    return !!mysqli_num_rows($res_);
  }
  
  $sql = "SELECT * FROM orbsMirrors";
  $res = mysqli_query($link, $sql);
  
  if(mysqli_num_rows($res)){
    $servers = [];
    for($i = 0; $i < mysqli_num_rows($res); ++$i){
      $row = mysqli_fetch_assoc($res);
      if($row['active'] && status($row)) $servers[] = $row;
    }
  }else{
    echo '[false]';
  }

  $pathname = explode('?',$_SERVER['REQUEST_URI']);
  if(sizeof($pathname)>1){
    $gamesel = explode('&', explode('gamesel=', $pathname[1])[1])[0];
    //echo $gamesel . "<br>";
    switch($gamesel){
      case 'tictactoe':
        $serverList = $servers;
        $tgturl = $serverList[rand()%sizeof($serverList)]['actualURL'].$gamesel;
      break;
      case 'tetris':
        $serverList = $servers;
        $tgturl = $serverList[rand()%sizeof($serverList)]['actualURL'].$gamesel;
      break;
      case 'orbs':
        $serverList = $servers;
        $tgturl = $serverList[rand()%sizeof($serverList)]['actualURL'].$gamesel;
      break;
      case 'sidetoside':
        $serverList = $servers;
        $tgturl = $serverList[rand()%sizeof($serverList)]['actualURL'].$gamesel;
      break;
      case 'puyopuyo':
        $serverList = $servers;
        $tgturl = $serverList[rand()%sizeof($serverList)]['actualURL'].$gamesel;
      break;
      case 'battleracer':
        $serverList = $servers;
        $tgturl = $serverList[rand()%sizeof($serverList)]['actualURL'].$gamesel;
      break;
    }
    echo "<meta http-equiv=\"refresh\" content=\"0,$tgturl\">";
    //echo json_encode($servers);
 }else{
    echo '[false]';
  }
?>
FILE;

file_put_contents('../launch/index.php', $file);

