import {expect, test} from '@playwright/test';
import common from './common';

test('The index page loads', async ({ page, context }) => {
    await page.goto(`${common.appUrl}`);
    await expect(page.getByRole('heading', { name: 'mmbd.io' })).toBeVisible();
});

test('The how it works link is shown and redirects to correct page', async ({page}) => {
    await page.goto(`${common.appUrl}`);
    await expect(page.getByRole('link', { name: 'How it works' })).toBeVisible()
    await page.getByRole('link', { name: 'How it works' }).click()
    await page.waitForURL('**/how-it-works', {
        waitUntil: 'domcontentloaded',
    });
    await expect(page.getByText('How it works')).toBeVisible()
})

test('Supported platforms are shown', async ({page}) => {
    await page.goto(`${common.appUrl}`);
    await expect(page.getByRole('heading', { name: 'Supported platforms' })).toBeVisible();
    await expect(page.getByRole('img', { name: 'YouTube Logo' })).toBeVisible();
    await expect(page.getByRole('img', { name: 'TikTok Logo' })).toBeVisible();
})

test('Detected platforms are shown correctly', async ({page}) => {
    await page.goto(`${common.appUrl}`);
    await page.getByPlaceholder('https://tiktok.com/').fill('https://www.youtube.com/watch?v=t9mcibMfENM');

    await expect(page.getByRole('heading', { name: 'Detected platform' })).toBeVisible();
    await expect(page.getByRole('heading', { name: 'Supported platforms' })).toHaveCount(0);

    await expect(page.getByRole('img', { name: 'YouTube Logo' })).toBeVisible();
    await expect(page.getByRole('img', { name: 'TikTok Logo' })).toHaveCount(0);
})
