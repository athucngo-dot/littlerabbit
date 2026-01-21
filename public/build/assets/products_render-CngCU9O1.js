function r(n){const l=document.getElementById("products-grid");n.forEach(e=>{const s=document.createElement("a");let a=`<p class="text-ink-60 mt-1">$${parseFloat(e.price).toFixed(2)}</p>`;parseFloat(e.price_after_deals)!=parseFloat(e.price)&&(a=`<p class="text-ink-60 mt-1">
                            <span>$${parseFloat(e.price_after_deals).toFixed(2)} </span>
                            (<span class="text-red-500">-${parseFloat(e.discount)}% </span>)
                        </p>
                        <p class="text-ink-60 mt-1">
                            <span class="text-sm">Was: </span>
                            <span class="line-through text-sm">$${parseFloat(e.price).toFixed(2)}</span>
                        </p>`,a+='<p class="text-ink-60 mt-1 text-xs">Eligible for Deals: </p>',e.deals.forEach(t=>{a+=`<p class="text-xs text-ink-60">
                                <span>${t.name} </span>
                                (<span class="text-red-500">-${parseFloat(t.percentage_off)}%</span>)
                             </p>`})),s.href=`/products/${e.slug}`,s.className="block bg-white rounded-xl shadow-md hover:shadow-lg overflow-hidden transition-transform transform hover:scale-105",s.innerHTML=`
            <div class="aspect-[3/4] flex items-center justify-center bg-[#ffe7a3]">
                <img src="${e.image}" alt="${e.name}" class="h-full w-full object-cover">
            </div>
            <div class="p-4 text-center">
                <h3 class="font-semibold text-lg text-ink">${e.name}</h3>
                `+a+`
            </div>
        `,l.appendChild(s)})}export{r};
